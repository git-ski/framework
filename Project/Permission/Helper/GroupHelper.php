<?php
declare(strict_types=1);

namespace Project\Permission\Helper;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\EventManager\EventManagerAwareInterface;
use Framework\EventManager\EventTargetInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\ViewModel\FormViewModelInterface;
use Project\Permission\Admin\View\ViewModel\Group\SubForm\AdminGroupViewModel;
use Std\Authentication\AuthenticationInterface;
use Project\Base\Admin\Controller\AbstractAdminController;
use Project\AdminUser\Admin\Controller\AdminUser\RegisterController as AdminUserRegisterController;
use Project\AdminUser\Admin\Controller\AdminUser\EditController as AdminUserEditController;
use Project\Permission\Entity\AdminGroupR;
use Project\Permission\Model\AdminGroupRModel;
use Project\Permission\Helper\ResourceHelper;
use Project\Permission\Helper\RbacHelper;
use Project\Permission\Helper\EntityFilter\QueryFilter;
use Std\EntityManager\EntityInterface;

class GroupHelper implements
    ObjectManagerAwareInterface,
    EventTargetInterface,
    EventManagerAwareInterface,
    EntityManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Framework\EventManager\EventTargetTrait;
    use \Framework\EventManager\EventManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;

    const TRIGGER_MISS_GROUPLIST = 'group.miss.grouplist';

    private $groupList = [];

    public function setGroupList($groupList)
    {
        $this->groupList = $groupList;
    }

    public function getGroupList()
    {
        if (empty($this->groupList)) {
            $this->triggerEvent(self::TRIGGER_MISS_GROUPLIST);
        }
        return $this->groupList;
    }

    public function injectGroupForm($TargetFormViewModel)
    {
        $TargetFormViewModel->addEventListener(
            FormViewModelInterface::TRIGGER_BEFORE_RENDER,
            [$this, 'setupAdminGroupForm']
        );
        $TargetFormViewModel->getContainer('SubForm')->addItem([
            'viewModel' => AdminGroupViewModel::class,
            'listeners' => [
                FormViewModelInterface::TRIGGER_FORMFINISH => [$this, 'onAdminGroupFinish']
            ]
        ]);
    }

    public function setupAdminGroupForm(\Framework\EventManager\Event $event)
    {
        $TargetFormView = $event->getTarget();
        $data           = $TargetFormView->getData();
        $AdminUser      = $data['admin'] ?? null;
        $AdminUser      = ($AdminUser instanceof EntityInterface) ? $AdminUser->toArray() : $AdminUser;
        if ($AdminUser) {
            $AdminGroupRModel= $this->getObjectManager()->get(AdminGroupRModel::class);
            $GroupR          = $AdminGroupRModel->getOneBy(['Admin' => $AdminUser['adminId']]);
            if ($GroupR) {
                $data['group'] = [
                    'groups' => $GroupR->getGroupId()
                ];
            }
            $TargetFormView->setData($data);
        }
    }

    public function onAdminGroupFinish(\Framework\EventManager\Event $event)
    {
        $ViewModel = $event->getTarget();
        $Form = $ViewModel->getForm();
        $groupId = $Form->getData('group')['groups'] ?? [];
        $this->getEventManager()
            ->addEventListener(
                AdminUserRegisterController::class,
                AbstractAdminController::TRIGGER_AFTER_CREATE,
                function ($event) use ($groupId) {
                    $AdminUser = $event->getData();
                    $this->makeAdminGroupRelation($AdminUser, $groupId);
                }
            )
            ->addEventListener(
                AdminUserEditController::class,
                AbstractAdminController::TRIGGER_AFTER_UPDATE,
                function ($event) use ($groupId) {
                    $AdminUser = $event->getData();
                    $this->makeAdminGroupRelation($AdminUser, $groupId);
                }
            );
    }

    public function makeAdminGroupRelation($AdminUser, $groupId)
    {
        // まずは対象AdminUserの旧グループ関係を削除
        $QueryBuilder = $this->getEntityManager()->createQueryBuilder();
        $QueryBuilder->delete(AdminGroupR::class, 'arr');
        $QueryBuilder->where('arr.Admin = :admin');
        $QueryBuilder->setParameters([
            'admin' => $AdminUser,
        ]);
        $QueryBuilder->getQuery()->execute();
        // そして、新たなグループ関係を作成
        if ($groupId) {
            $AdminGroupRModel = $this->getObjectManager()->get(AdminGroupRModel::class);
            $AdminGroupRModel->create([
                'Admin' => $AdminUser,
                'groupId'  => $groupId
            ]);
        }
    }

    public function setupAdminGroup(AuthenticationInterface $AdminAuthentication)
    {
        $Identity = $AdminAuthentication->getIdentity();
        if (empty($Identity['group'])) {
            $EntityManager = $this->getEntityManager();
            $EntityManager->getFilters()->disable(QueryFilter::uniqid());
            $AdminGroupRModel = $this->getObjectManager()->get(AdminGroupRModel::class);
            $AdminGroupR = $AdminGroupRModel->getOneBy([
                'Admin' => $Identity['adminId']
            ]);
            if ($AdminGroupR) {
                $groupMembers = array_map(function ($group) {
                    return $group->getAdmin()->getAdminId();
                }, $AdminGroupRModel->getList([
                    'groupId' => $AdminGroupR
                ]));
                $Identity = array_merge($Identity, [
                    ResourceHelper::ENTITY_GRP_POSTFIX => $groupMembers,
                ]);
                $Identity = $this->getObjectManager()->get(RbacHelper::class)->updateQueryFilter($Identity);
                $AdminAuthentication->updateIdentity($Identity);
            }
            $EntityManager->getFilters()->enable(QueryFilter::uniqid());
        }
    }
}
