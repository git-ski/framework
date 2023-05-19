<?php
declare(strict_types=1);

namespace Project\Permission\Helper;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\Controller\ControllerInterface;
use Std\Authentication\AuthenticationAwareInterface;
use Std\AclManager\AclManagerAwareInterface;
use Std\AclManager\RbacAwareInterface;
use Std\AclManager\RbacInterface;
use Std\RouterManager\RouterManagerAwareInterface;
use Std\EntityManager\EntityModelInterface;
use Std\FormManager\Form;
use Std\FormManager\Element\Id;
use Std\TranslatorManager\TranslatorManagerAwareInterface;
use Std\ValidatorManager\ValidatorInterface;
use Project\Base\Admin\Controller\AbstractAdminController;
use Project\AdminUser\Model\AdminModel;
use Project\Permission\Model;
use Project\Base\Front\Controller\ForbiddenController;
use Project\Permission\Helper\EntityFilter\QueryFilter;
use Project\Permission\Helper\EntityFilter\SimpleAdapter;

class RbacHelper implements
    ObjectManagerAwareInterface,
    AuthenticationAwareInterface,
    AclManagerAwareInterface,
    RouterManagerAwareInterface,
    RbacAwareInterface,
    TranslatorManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;
    use \Std\Authentication\AuthenticationAwareTrait;
    use \Std\AclManager\AclManagerAwareTrait;
    use \Std\AclManager\RbacAwareTrait;
    use \Std\RouterManager\RouterManagerAwareTrait;
    use \Std\TranslatorManager\TranslatorManagerAwareTrait;
    use \Std\Renderer\AwareFilterHelperTrait;

    const ENTITY_PERMISSION_DENIED_MESSAGE = 'ENTITY_PERMISSION_DENIED_MESSAGE';

    public function setupAdminRbac($Identity)
    {
        $Identity = $this->prepareIdentity($Identity);
        $adminId    = $Identity['adminId'];
        $Rbac = $this->getRbac();
        [$Roles, $roleList] = $this->getRoleList($adminId);
        $Rbac->setRoles($roleList);
        // セッションにすでにACLがあれば、セッションのACLをRBACに適用
        if (isset($Identity[RbacInterface::class])) {
            $Rbac->setAcl($Identity[RbacInterface::class]);
        } else {
            // セッションにACLがなければ、DB(あるいはキャッシュ)またはRolesからACLを再取得し、RBACに適用
            if (!$this->restoreRbacFromStorage($Rbac, $adminId)) {
                $this->restoreRbacWithRoles($Rbac, $adminId, $Roles);
            }
            $Identity[RbacInterface::class] = $Rbac->getAcl();
        }
        $Identity = $this->updateQueryFilter($Identity);
        $EntityManager = $this->getEntityManager();
        $EntityManager->getConfiguration()->addFilter(QueryFilter::uniqid(), QueryFilter::class);
        $EntityManager->getFilters()->enable(QueryFilter::uniqid());
        return $Identity;
    }

    public function removeAdminAcl()
    {
        // DBの旧レコードから再構築させないように、DBからも削除
        $AdminAclModel = $this->getObjectManager()->get(Model\AdminAclModel::class);
        $QueryBuilder = $AdminAclModel->getRepository()->createQueryBuilder('aa');
        $QueryBuilder->delete();
        $QueryBuilder->getQuery()->execute();
    }

    public function adjustRouterRbac(ControllerInterface $Controller)
    {
        $Rbac       = $this->getRbac();
        $Router     = $this->getRouterManager()->getMatched();
        $url        = $Router->linkto(get_class($Controller));
        $resource   = preg_replace('/^\//', '', $url);
        if (!$Rbac->isAllowed($resource)) {
            $Router->redirect(ForbiddenController::class);
        }
    }

    public function adjustEntityRbac(Form $Form)
    {
        $Rbac = $this->getRbac();
        foreach ($Form->getAllElements() as $Element) {
            if ($Element instanceof Id) {
                $options = $Element->getOptions();
                $resource  = $options['target'] ?? null;
                $privilege = $options['action'] ?? null;
                if (!$resource || !$privilege) {
                    continue;
                }
                // 対象コンテンツの任意変更権限があれば
                $privilegeAll = $privilege . ResourceHelper::ENTITY_ALL_POSTFIX;
                if ($Rbac->isAllowed($resource, $privilegeAll)) {
                    continue;
                }
                // 自身のコンテンツの変更権限があるか？
                if ($value = $Element->getValue()) {
                    $privilegeOwn = $privilege . ResourceHelper::ENTITY_OWN_POSTFIX;
                    $Resource = $this->getEntityManager()->getRepository($resource)->find($value);
                    $createAdminId = is_callable([$Resource, 'getCreateAdminId']) ? $Resource->getCreateAdminId() : null;
                    if (!$createAdminId) {
                        continue;
                    }
                    $Identity = $this->getAuthentication()->getIdentity();
                    // 自身のコンテンツかを判定する
                    if ($Rbac->isAllowed($resource, $privilegeOwn) && $createAdminId === $Identity['adminId']) {
                        continue;
                    }
                    $privilegeGrp = $privilege . ResourceHelper::ENTITY_GRP_POSTFIX;
                    if ($Rbac->isAllowed($resource, $privilegeGrp)) {
                        $groupMembers = $Identity[ResourceHelper::ENTITY_GRP_POSTFIX] ?? [];
                        if (in_array($createAdminId, $groupMembers)) {
                            continue;
                        }
                    }
                }
                $Translator = $this->getTranslatorManager()->getTranslator(ValidatorInterface::class);
                $Element->setError($Translator->translate(self::ENTITY_PERMISSION_DENIED_MESSAGE));
                $Element->setErrorClass('has-error has-feedback');
                $Form->forceError();
                $Form->every(function ($element) {
                    $element->setAttr('disabled', 'disabled');
                });
                break;
            }
        }
    }

    /**
     * DBにACLがあれば、DBのACLからRBACを復元、そしてそのACLをセッションに持つ。
     *
     * @param RbacInterface $Rbac
     * @param mixed $adminId
     * @return bool
     */
    private function restoreRbacFromStorage(RbacInterface $Rbac, $adminId)
    {
        $AdminAclModel     = $this->getObjectManager()->get(Model\AdminAclModel::class);
        $AdminAcl          = $AdminAclModel->getOneBy([
            'Admin' => $adminId
        ]);
        if ($AdminAcl) {
            $serializedAcl = $AdminAcl->getAcl();
            if (is_resource($serializedAcl) && 'stream' === get_resource_type($serializedAcl)) {
                $serializedAcl = stream_get_contents($serializedAcl);
            }
            // 保存時は、gzencodeなので、ここでdecodeしておく。
            // それに、保存したACLが破損した場合、falseを返して再構築させる。
            $decodedAcl = gzdecode($serializedAcl);
            if (false === $decodedAcl) {
                return false;
            }
            $Rbac->restoreSerializedAcl($decodedAcl);
            return true;
        }
        return false;
    }

    /**
     * ACLがなければ、RoleとRoleResourceから、ACLを再構築する、構築完了ACLをDBおよびセッションに持つ。
     *
     * @param RbacInterface $Rbac
     * @param mixed $adminId
     * @param array $Roles
     * @return void
     */
    private function restoreRbacWithRoles(RbacInterface $Rbac, $adminId, array $Roles)
    {
        //
        $AclManager        = $this->getAclManager();
        $this->getObjectManager()->get(RoleHelper::class)->apply($AclManager);
        $RoleResourceModel = $this->getObjectManager()->get(Model\RoleResourceModel::class);
        $RoleResourceMatrix = $RoleResourceModel->getMatrixByRoles($Roles);
        $Rbac->build($RoleResourceMatrix);
        $AdminAclModel     = $this->getObjectManager()->get(Model\AdminAclModel::class);
        $AdminAclModel->create([
            'Admin' => $adminId,
            'acl'   => gzencode($Rbac->getSerializedAcl())
        ]);
    }

    public function adjustRouterList()
    {
        $Rbac = $this->getRbac();
        $Router = $this->getRouterManager()->getMatched();
        $routerList = [];
        foreach ($Router->getRouterList() as $url => $Controller) {
            if ($Rbac->isAllowed($url)) {
                $routerList[$url] = $Controller;
            }
        }
        $Router->setRouterList($routerList);
    }

    public function updateQueryFilter($Identity)
    {
        $filters = [];
        $Rbac = $this->getRbac();
        $ResourceHelper = $this->getObjectManager()->get(ResourceHelper::class);
        $EntityManager = $this->getEntityManager();
        $ReadFilter = [
            ResourceHelper::ENTITY_ALL_POSTFIX => [
                'resourcePrivilegeGenerator' => $ResourceHelper->generateEntityResourcePrivilege(
                    $EntityManager,
                    [ EntityModelInterface::ACTION_READ . ResourceHelper::ENTITY_ALL_POSTFIX ]
                ), 'granted' => $Identity[ResourceHelper::ENTITY_ALL_POSTFIX]
            ],
            ResourceHelper::ENTITY_GRP_POSTFIX => [
                'resourcePrivilegeGenerator' => $ResourceHelper->generateEntityResourcePrivilege(
                    $EntityManager,
                    [ EntityModelInterface::ACTION_READ . ResourceHelper::ENTITY_GRP_POSTFIX ]
                ), 'granted' => $Identity[ResourceHelper::ENTITY_GRP_POSTFIX]
            ],
            ResourceHelper::ENTITY_OWN_POSTFIX => [
                'resourcePrivilegeGenerator' => $ResourceHelper->generateEntityResourcePrivilege(
                    $EntityManager,
                    [ EntityModelInterface::ACTION_READ . ResourceHelper::ENTITY_OWN_POSTFIX ]
                ), 'granted' => [ $Identity['adminId']]
            ]
        ];
        foreach ($ReadFilter as $level => ['resourcePrivilegeGenerator' => $resourcePrivilegeGenerator, 'granted' => $granted]) {
            foreach ($resourcePrivilegeGenerator as ['resource' => $resource, 'privilege' => $privilege]) {
                if (empty($filters[$resource]) && $Rbac->isAllowed($resource, $privilege)) {
                    $filters[$resource] = $granted;
                }
            }
        }
        QueryFilter::getAdapter()->setGranted($filters);
        return $Identity;
    }

    private function getRoleList($adminId)
    {
        $AdminRoleRModel = $this->getObjectManager()->get(Model\AdminRoleRModel::class);
        $Roles    = array_map(function ($AdminRoleR) {
            return $AdminRoleR->getRole();
        }, $AdminRoleRModel->getList([
            'Admin' => $adminId
        ]));
        $roleList = array_map(function ($Role) {
            return $Role->getRole();
        }, $Roles);
        return [$Roles, $roleList];
    }

    private function prepareIdentity($Identity)
    {
        if (empty($Identity[ResourceHelper::ENTITY_ALL_POSTFIX])) {
            $AdminModel = $this->getObjectManager()->get(AdminModel::class);
            $QueryBuilder = $AdminModel->getRepository()->createQueryBuilder('a');
            $QueryBuilder->select('a.adminId');
            $result = $QueryBuilder->getQuery()->getResult();
            $Identity[ResourceHelper::ENTITY_ALL_POSTFIX] = array_column($result, 'adminId');
        }
        if (empty($Identity[ResourceHelper::ENTITY_GRP_POSTFIX])) {
            $Identity[ResourceHelper::ENTITY_GRP_POSTFIX] = [];
        }
        return $Identity;
    }

    public function reloadRbac()
    {
        $Authentication = $this->getAuthentication();
        $this->removeAdminAcl();
        $Identity = $Authentication->getIdentity();
        unset($Identity[RbacInterface::class]);
        unset($Identity[ResourceHelper::ENTITY_ALL_POSTFIX]);
        unset($Identity[ResourceHelper::ENTITY_ALL_POSTFIX]);
        $Identity = $this->setupAdminRbac($Identity);
        $Authentication->updateIdentity($Identity);
    }

    public function extendsTwig()
    {
        $this->getFilterHelper()->addFilter('Canbe', function ($Model, $privilege, $EntityOrId) {
            $Rbac = $this->getRbac();
            $Model = $this->getObjectManager()->get($Model);
            $resource   = $Model->getRepository()->getClassName();
            if ($Rbac->isAllowed($resource, $privilege . ResourceHelper::ENTITY_ALL_POSTFIX)) {
                return true;
            }
            $Entity     = $Model->get($EntityOrId);
            if (!$Entity) {
                return false;
            }
            $Identity = $this->getAuthentication()->getIdentity();
            if ($Rbac->isAllowed($resource, $privilege . ResourceHelper::ENTITY_GRP_POSTFIX)) {
                $createCompanyId = is_callable([$Entity, 'getCreateCompanyId']) ? $Entity->getCreateCompanyId() : null;
                $identityCompanyId = $Identity['fakeCompanyId'] ?? $Identity['createCompanyId'];
                if ($createCompanyId && $createCompanyId == $identityCompanyId) {
                    return true;
                }
            }
            if ($Rbac->isAllowed($resource, $privilege . ResourceHelper::ENTITY_OWN_POSTFIX)) {
                $createAdminId = is_callable([$Entity, 'getCreateAdminId']) ? $Entity->getCreateAdminId() : null;
                if ($createAdminId && $createAdminId == $Identity['adminId']) {
                    return true;
                }
            }
            return false;
        });
    }
}
