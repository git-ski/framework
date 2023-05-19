<?php
declare(strict_types=1);

namespace Project\AdminUser\Admin\Authentication;

use Framework\EventManager\AbstractEventListenerManager;
use Std\Authentication\AuthenticationInterface;
use Std\Controller\ControllerInterface;
use Project\Base;
use Project\AdminUser\Admin\Controller;
use Std\EntityManager\AbstractEntityModel;
use Project\AdminUser\Admin\View\ViewModel\Authentication\AuthenticatedViewModel;
use Project\AdminUser\Admin\Authentication\Authentication as AdminAuthentication;

class EventListenerManager extends AbstractEventListenerManager implements
    \Std\RouterManager\RouterManagerAwareInterface,
    \Std\AclManager\AclManagerAwareInterface,
    \Std\AclManager\RbacAwareInterface
{
    use \Std\RouterManager\RouterManagerAwareTrait;
    use \Std\AclManager\AclManagerAwareTrait;
    use \Std\AclManager\RbacAwareTrait;

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $this->getEventManager()
            ->addEventListener(
                AdminAuthentication::class,
                AuthenticationInterface::TRIGGER_AUTHENTICATE,
                [$this, 'onAuthenticate']
            )
            ->addEventListener(
                Base\Admin\Controller\AbstractAdminController::class,
                ControllerInterface::TRIGGER_BEFORE_ACTION,
                [$this, 'authenticateSession']
            )
            ->addEventListener(
                Base\Api\Controller\AbstractAdminRestfulController::class,
                ControllerInterface::TRIGGER_BEFORE_ACTION,
                [$this, 'apiAuthenticateSession']
            )
            ->addEventListener(
                Base\Admin\View\ViewModel\SidemenuViewModel::class,
                \Framework\EventManager\EventTargetInterface::TRIGGER_INITED,
                [$this, 'injectAdminProfile']
            );
    }

    public function onAuthenticate(\Framework\EventManager\Event $event)
    {
        $Authentication = $event->getTarget();
        $this->getObjectManager()->set(AuthenticationInterface::class, $Authentication);
        if ($Authentication->hasIdentity()) {
            $Identity = $Authentication->getIdentity();
            $this->setDefaultAdminId($Identity['adminId']);
        }
    }

    public function authenticateSession(\Framework\EventManager\Event $event)
    {
        $Authentication = $this->getObjectManager()->get(AdminAuthentication::class);
        if (!$Authentication->hasIdentity()) {
            return $this->getRouterManager()->getMatched()->redirect(Controller\LoginController::class);
        }
        $Authentication->triggerEvent(AuthenticationInterface::TRIGGER_AUTHENTICATE);
        // ログインしているが、仮パスワードの状態のであれば、仮パスワード画面にリタイレクトする
        $Identity = $Authentication->getIdentity();
        $this->setDefaultAdminId($Identity['adminId']);
        if ($Identity['tempPasswordFlag']) {
            // 仮パスワード画面はリタイレクトしない
            $Controller = $event->getTarget();
            if ($Controller instanceof Controller\AdminUser\PasswordController) {
                return;
            }
            // ログアウト画面もリタイレクトしない
            if ($Controller instanceof Controller\LogoutController) {
                return;
            }
            $this->getRouterManager()->getMatched()->redirect(Controller\AdminUser\PasswordController::class);
        }
    }

    public function apiAuthenticateSession(\Framework\EventManager\Event $event)
    {
        $Authentication = $this->getObjectManager()->get(AdminAuthentication::class);
        if (!$Authentication->hasIdentity()) {
            $ApiController = $event->getTarget();
            return $ApiController->callAction('notFound');
        }
        $Authentication->triggerEvent(AuthenticationInterface::TRIGGER_AUTHENTICATE);
    }

    public function injectAdminProfile(\Framework\EventManager\Event $event)
    {
        $SidemenuViewModel = $event->getTarget();
        $Authentication  = $this->getObjectManager()->get(AdminAuthentication::class);
        if ($Authentication->hasIdentity()) {
            $SidemenuViewModel->getContainer(Base\Admin\View\ViewModel\SidemenuViewModel::LEFT_TOP)->addItem([
                'viewModel' => AuthenticatedViewModel::class,
                'data'      => [
                    'adminUser' => $Authentication->getIdentity()
                ]
            ]);
        }
    }

    private function setDefaultAdminId($adminId)
    {
        AbstractEntityModel::setDefaultCreateAdminId($adminId);
        AbstractEntityModel::setDefaultUpdateAdminId($adminId);
    }
}
