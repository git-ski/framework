<?php
declare(strict_types=1);

namespace Project\Permission\Helper;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\EventManager\EventManagerAwareInterface;
use Std\ViewModel\FormViewModelInterface;
use Project\Permission\Admin\View\ViewModel\Role\SubForm\AdminRoleViewModel;
use Project\Base\Admin\Controller\AbstractAdminController;
use Project\AdminUser\Admin\Controller\AdminUser\RegisterController as AdminUserRegisterController;
use Project\AdminUser\Admin\Controller\AdminUser\EditController as AdminUserEditController;
use Project\Permission\Entity\AdminRoleR;
use Project\Permission\Model\AdminRoleRModel;
use Std\Authentication\AuthenticationAwareInterface;
use Std\AclManager\RbacAwareInterface;
use Std\AclManager\AclManagerInterface;
use Project\Permission\Model\RoleModel;
use Std\EntityManager\EntityInterface;

class RoleHelper implements
    ObjectManagerAwareInterface,
    EventManagerAwareInterface,
    AuthenticationAwareInterface,
    RbacAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Framework\EventManager\EventManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;
    use \Std\Authentication\AuthenticationAwareTrait;
    use \Std\AclManager\RbacAwareTrait;

    public function injectRoleForm($TargetFormViewModel)
    {
        $TargetFormViewModel->addEventListener(
            FormViewModelInterface::TRIGGER_BEFORE_RENDER,
            [$this, 'setupAdminRoleForm']
        );
        $TargetFormViewModel->getContainer('SubForm')->addItem([
            'viewModel' => AdminRoleViewModel::class,
            'listeners' => [
                FormViewModelInterface::TRIGGER_FORMFINISH => [$this, 'onAdminRoleFinish']
            ]
        ]);
    }

    public function setupAdminRoleForm(\Framework\EventManager\Event $event)
    {
        $TargetFormView = $event->getTarget();
        $data           = $TargetFormView->getData();
        $AdminUser      = $data['admin'] ?? null;
        $AdminUser      = ($AdminUser instanceof EntityInterface) ? $AdminUser->toArray() : $AdminUser;
        if (!empty($AdminUser['adminId'])) {
            $AdminRoleRModel= $this->getObjectManager()->get(AdminRoleRModel::class);
            $Roles          = $AdminRoleRModel->getList(['Admin' => $AdminUser['adminId']]);
            $data['role']   = [
                'roles' => array_map(function ($Role) {
                    return $Role->getRole()->getRoleId();
                }, $Roles)
            ];
            $TargetFormView->setData($data);
        }
    }

    public function onAdminRoleFinish(\Framework\EventManager\Event $event)
    {
        $ViewModel = $event->getTarget();
        $Form      = $ViewModel->getForm();
        $roles     = $Form->getData('role')['roles'] ?? [];
        $this->getEventManager()
            ->addEventListener(
                AdminUserRegisterController::class,
                AbstractAdminController::TRIGGER_AFTER_CREATE,
                function ($event) use ($roles) {
                    $AdminUser = $event->getData();
                    $this->makeAdminRoleRelation($AdminUser, $roles);
                    $this->updateRbac($AdminUser);
                }
            )
            ->addEventListener(
                AdminUserEditController::class,
                AbstractAdminController::TRIGGER_AFTER_UPDATE,
                function ($event) use ($roles) {
                    $AdminUser = $event->getData();
                    $this->makeAdminRoleRelation($AdminUser, $roles);
                    $this->updateRbac($AdminUser);
                }
            );
    }

    public function makeAdminRoleRelation($AdminUser, $roles)
    {
        // まずは対象AdminUserの旧ロール関係を削除
        $QueryBuilder = $this->getEntityManager()->createQueryBuilder();
        $QueryBuilder->delete(AdminRoleR::class, 'arr');
        $QueryBuilder->where('arr.Admin = :admin');
        $QueryBuilder->setParameters([
            'admin' => $AdminUser,
        ]);
        $QueryBuilder->getQuery()->execute();
        // そして、新たなRole関係を作成
        $AdminRoleRModel = $this->getObjectManager()->get(AdminRoleRModel::class);
        foreach ($roles as $role) {
            $AdminRoleRModel->create([
                'Admin' => $AdminUser,
                'Role'  => $role
            ]);
        }
    }

    private function updateRbac($AdminUser)
    {
        $Identity = $this->getAuthentication()->getIdentity();
        // 自身のロールが更新されるかもしれないので、Rbacを更新する。
        if ($Identity['adminId'] === $AdminUser->getAdminId()) {
            $this->getObjectManager()->get(RbacHelper::class)->reloadRbac();
        }
    }

    public function apply(AclManagerInterface $AclManager)
    {
        $RoleModel = $this->getObjectManager()->get(RoleModel::class);
        foreach ($RoleModel->getList() as $Role) {
            $AclManager->registerRole($Role->getRole());
        }
        return $AclManager;
    }
}
