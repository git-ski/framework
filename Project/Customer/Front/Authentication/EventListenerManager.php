<?php
declare(strict_types=1);

namespace Project\Customer\Front\Authentication;

use Std\Authentication\AuthenticationInterface;
use Project\Customer\Front\Authentication\Authentication as CustomerAuthentication;
use Framework\EventManager\AbstractEventListenerManager;
use Std\RouterManager\RouterManagerAwareInterface;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Project\Base\Front\Controller\AbstractController as FrontController;
use Project\Base\Front\Controller\AuthControllerInterface;
use Project\Customer\Front\Controller\Login\LoginController;
use Project\Customer\Front\Controller\Login\LogoutController;
use Project\Customer\Front\Controller\Login\PasswordController;
use Project\Base\Front\View\ViewModel\ModalMenuViewModel;
use Project\Customer\Front\View\ViewModel\Authentication\AuthenticatedViewModel;
use Project\Customer\Front\View\ViewModel\Authentication\NoneAuthenticatedViewModel;

class EventListenerManager extends AbstractEventListenerManager implements
    RouterManagerAwareInterface,
    HttpMessageManagerAwareInterface
{
    use \Std\RouterManager\RouterManagerAwareTrait;
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $this->getEventManager()
            ->addEventListener(
                FrontController::class,
                FrontController::TRIGGER_BEFORE_ACTION,
                [$this, 'exportCustomerAuthenticate']
            )
            ->addEventListener(
                AuthControllerInterface::class,
                AuthControllerInterface::TRIGGER_BEFORE_ACTION,
                [$this, 'authentication']
            )
            ->addEventListener(
                ModalMenuViewModel::class,
                ModalMenuViewModel::TRIGGER_INITED,
                [$this, 'injectModalMenu'],
                -1
            );
    }

    public function exportCustomerAuthenticate(\Framework\EventManager\Event $event)
    {
        $CustomerAuthentication = $this->getObjectManager()->get(CustomerAuthentication::class);
        $this->getObjectManager()->set(AuthenticationInterface::class, $CustomerAuthentication);
    }

    public function authentication($event)
    {
        $Authentication = $this->getObjectManager()->get(CustomerAuthentication::class);
        if (!$Authentication->hasIdentity()) {
            $this->getRouter()->redirect(LoginController::class, null, [], $pushHistory = true);
        }
        // SEC_FRAME-19 その他 認証後以降のページでは、キャッシュコントロールをno-storeにする
        $Reponse = $this->getHttpMessageManager()->getResponse();
        $this->getHttpMessageManager()->setResponse($Reponse->withHeader('Cache-Control', 'no-store'));
        // ログインしているが、仮パスワードの状態のであれば、仮パスワード画面にリタイレクトする
        $Identity = $Authentication->getIdentity();
        if ($Identity['tempPasswordFlag']) {
            // 仮パスワード画面はリタイレクトしない
            $Controller = $event->getTarget();
            if ($Controller instanceof PasswordController) {
                return;
            }
            // ログアウト画面もリタイレクトしない
            if ($Controller instanceof LogoutController) {
                return;
            }
            $this->getRouterManager()->getMatched()->redirect(PasswordController::class);
        }
    }

    public function apiAuthentication($event)
    {
        $Authentication = $this->getObjectManager()->get(CustomerAuthentication::class);
        if (!$Authentication->hasIdentity()) {
            $ApiController = $event->getTarget();
            $ApiController->callAction('notFound');
        }
    }

    public function injectModalMenu($event)
    {
        $ModalMenuViewModel = $event->getTarget();
        $Authentication  = $this->getObjectManager()->get(CustomerAuthentication::class);
        if ($Authentication->hasIdentity()) {
            $ModalMenuViewModel->getContainer(ModalMenuViewModel::MENU_MIDDLE)->addItem([
                'viewModel' => AuthenticatedViewModel::class
            ]);
        } else {
            $ModalMenuViewModel->getContainer(ModalMenuViewModel::MENU_MIDDLE)->addItem([
                'viewModel' => NoneAuthenticatedViewModel::class
            ]);
        }
    }
}
