<?php
declare(strict_types=1);

namespace Project\Customer\Front\Controller\Login;

use Project\Base\Front\Controller\AbstractController;
use Std\ViewModel\ViewModelManager;
use Project\Customer\Front\View\ViewModel\Login\LoginViewModel;
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;
use Project\Customer\Front\Controller\Customer\ProfileController;
use Std\SessionManager\SessionManagerAwareInterface;
use Project\Customer\Front\Controller\Login\LoginModel as CustomerLoginModel;
use Std\SessionManager\FlashMessage;

class LoginController extends AbstractController implements
    AuthenticationAwareInterface,
    SessionManagerAwareInterface
{
    use \Std\Authentication\AuthenticationAwareTrait;
    use \Std\SessionManager\SessionManagerAwareTrait;

    const LOGIN = 'input_login';
    const TRIGGER_LOGINFINISH = 'login.finish';

    public function index(): LoginViewModel
    {
        if ($this->getAuthentication()->hasIdentity()) {
            $this->getRouter()->redirect(ProfileController::class);
        }
        $Session = $this->getSessionManager()->getSession(self::LOGIN);
        $Session->login = null;

        return $this->getViewModelManager()->getViewModel([
            'viewModel' => LoginViewModel::class,
            'data'=>[
            ],
            'listeners' => [
                LoginViewModel::TRIGGER_FORMFINISH => [$this, 'onLoginFinish']
            ]
        ]);
    }

    public function onLoginFinish(\Framework\EventManager\Event $event): void
    {
        $LoginViewModel = $event->getTarget();
        $customerLogin = $LoginViewModel->getForm()->getData()['customerLogin'];
        $Session = $this->getSessionManager()->getSession(self::LOGIN);
        $Session->login = $customerLogin['login'];
        $this->triggerEvent(self::TRIGGER_LOGINFINISH, $customerLogin['login']);
        $this->getRouter()->redirect(LoginPasswordController::class);
    }

    public static function getPageInfo(): array
    {
        return [
            "description" => "Log In ", //
            "title" => "Log In ", // title
            "site_name" => "site_name", // titleの|以降
            "lower_title" => "Log In ", // マイページ系の表示タイトル
            "meta_description" => "meta_description", // description
            "meta_keywords" => "meta_keywords", // keywords
            "og_title" => "og_title", // og:title
            "og_description" => "og_description", // og:description
            "og_site_name" => "og_site_name", // og:site_name
            "og_type" => "article", // og:type
            "priority" => 0,
            "menu" => false,
        ];
    }
}
