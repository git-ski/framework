<?php
declare(strict_types=1);

namespace Project\Permission\Admin;

use Framework\Application\ApplicationInterface;
use Framework\EventManager\AbstractEventListenerManager;
use Framework\EventManager\EventTargetInterface;
use Std\RouterManager\RouterInterface;
use Std\Controller\ControllerInterface;
use Std\Authentication\AuthenticationInterface;
use Std\AclManager\AclManagerAwareInterface;
use Std\TranslatorManager\TranslatorManagerInterface;
use Std\AclManager\RbacAwareInterface;
use Std\AclManager\RbacInterface;
use Std\RouterManager\RouterManagerAwareInterface;
use Std\RouterManager\Http\Router;
use Std\EntityManager;
use Std\ViewModel\FormViewModelInterface;
use Std\FormManager\Form;
use Project\Base\Admin\Controller\AbstractAdminController;
use Project\AdminUser\Admin\View\ViewModel\AdminUser\RegisterViewModel;
use Project\AdminUser\Admin\View\ViewModel\AdminUser\EditViewModel;
use Project\AdminUser\Admin\Authentication\Authentication as AdminAuthentication;
use Project\Permission\Helper\ResourceHelper;
use Project\Permission\Helper\RbacHelper;
use Project\Permission\Helper\RoleHelper;
use Project\Permission\Helper\GroupHelper;

class EventListenerManager extends AbstractEventListenerManager implements
    AclManagerAwareInterface,
    RouterManagerAwareInterface,
    RbacAwareInterface
{
    use \Std\AclManager\AclManagerAwareTrait;
    use \Std\AclManager\RbacAwareTrait;
    use \Std\RouterManager\RouterManagerAwareTrait;

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $this->getEventManager()
            ->addEventListener(
                Router::class, RouterInterface::TRIGGER_ROUTERLIST_LOADED, [$this, 'populateRouterResource']
            )
            ->addEventListener(
                ApplicationInterface::class, ApplicationInterface::TRIGGER_BEFORE_BUILD_RESPONSE, [$this, 'adjustRouterList']
            )
            ->addEventListener(
                EntityManager\FactoryInterface::class, EntityManager\FactoryInterface::TRIGGER_ENTITY_MANAGER_CREATED, [$this, 'populateEntityResource']
            )
            ->addEventListener(
                Controller\Permission\ConfigurationController::class, AbstractAdminController::TRIGGER_AFTER_UPDATE, [$this, 'removeAdminAcl']
            )
            ->addEventListener(
                Controller\Role\RegisterController::class, AbstractAdminController::TRIGGER_AFTER_CREATE, [$this, 'removeAdminAcl']
            )
            ->addEventListener(
                Controller\Role\EditController::class, AbstractAdminController::TRIGGER_AFTER_UPDATE, [$this, 'removeAdminAcl']
            )
            ->addEventListener(
                Controller\Role\DeleteController::class, AbstractAdminController::TRIGGER_AFTER_DELETE, [$this, 'removeAdminAcl']
            )
            ->addEventListener(
                AbstractAdminController::class, AbstractAdminController::TRIGGER_BEFORE_ACTION, [$this, 'adjustRouterRbac']
            )
            ->addEventListener(
                Form::class, Form::TRIGGER_START, [$this, 'adjustEntityRbac']
            )
            ->addEventListener(
                Form::class, Form::TRIGGER_SUBMIT, [$this, 'adjustEntityRbac']
            )
            ->addEventListener(
                RegisterViewModel::class, FormViewModelInterface::TRIGGER_FORMINIT, [$this, 'injectRoleGroupForm']
            )
            ->addEventListener(
                EditViewModel::class, FormViewModelInterface::TRIGGER_FORMINIT, [$this, 'injectRoleGroupForm']
            )
            ->addEventListener(
                AdminAuthentication::class, AuthenticationInterface::TRIGGER_AUTHENTICATE, [$this, 'setupAdminRbacGroup']
            );
    }

    public function populateRouterResource(\Framework\EventManager\Event $event)
    {
        $ResourceHelper = $this->getObjectManager()->get(ResourceHelper::class);
        $Router         = $event->getTarget();
        $ResourceHelper->populateRouterResource($Router);
    }

    public function populateEntityResource($event)
    {
        $ResourceHelper    = $this->getObjectManager()->get(ResourceHelper::class);
        ['EntityManager' => $EntityManager ] = $event->getData();
        $ResourceHelper->populateEntityResource($EntityManager);
    }

    public function removeAdminAcl(\Framework\EventManager\Event $event)
    {
        // セッションからACLを削除する
        $RbacHelper          = $this->getObjectManager()->get(RbacHelper::class);
        $AdminAuthentication = $this->getObjectManager()->get(AdminAuthentication::class);
        $RbacHelper->removeAdminAcl();
        // セッションからACLも削除する
        $AdminAuthentication->updateIdentity([
            RbacInterface::class => null
        ]);
    }

    public function adjustRouterRbac(\Framework\EventManager\Event $event)
    {
        $RbacHelper = $this->getObjectManager()->get(RbacHelper::class);
        $Controller = $event->getTarget();
        $RbacHelper->adjustRouterRbac($Controller);
    }

    public function adjustEntityRbac(\Framework\EventManager\Event $event)
    {
        $RbacHelper = $this->getObjectManager()->get(RbacHelper::class);
        $Form = $event->getTarget();
        $RbacHelper->adjustEntityRbac($Form);
    }

    public function injectRoleGroupForm(\Framework\EventManager\Event $event)
    {
        $adminFormViewModel = $event->getTarget();
        $RoleHelper          = $this->getObjectManager()->get(RoleHelper::class);
        $RoleHelper->injectRoleForm($adminFormViewModel);
        $GroupHelper          = $this->getObjectManager()->get(GroupHelper::class);
        $GroupHelper->injectGroupForm($adminFormViewModel);
    }

    public function adjustRouterList(\Framework\EventManager\Event $event)
    {
        $RbacHelper = $this->getObjectManager()->get(RbacHelper::class);
        $RbacHelper->adjustRouterList();
    }

    public function setupAdminRbacGroup(\Framework\EventManager\Event $event)
    {
        $RbacHelper             = $this->getObjectManager()->get(RbacHelper::class);
        $AdminAuthentication    = $event->getTarget();
        $Identity               = $RbacHelper->setupAdminRbac($AdminAuthentication->getIdentity());
        $AdminAuthentication->updateIdentity($Identity);
        $GroupHelper            = $this->getObjectManager()->get(GroupHelper::class);
        $GroupHelper->setupAdminGroup($AdminAuthentication);
    }
}
