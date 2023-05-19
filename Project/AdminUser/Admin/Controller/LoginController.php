<?php
declare(strict_types=1);

namespace Project\AdminUser\Admin\Controller;

use Std\ViewModel\ViewModelManager;
use Project\AdminUser\Admin\View\ViewModel\LoginViewModel;
use Project\AdminUser\Admin\Authentication\AuthenticationAwareInterface;
use Project\Base\Front\Controller\AbstractController;
use Project\Base\Admin\Controller\DashboardController;
use Std\SessionManager\SessionManagerAwareInterface;

class LoginController extends AbstractController implements
    AuthenticationAwareInterface,
    SessionManagerAwareInterface
{
    use \Std\Authentication\AuthenticationAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;
    use \Std\SessionManager\SessionManagerAwareTrait;

    public function index(): LoginViewModel
    {
        if ($this->getAuthentication()->hasIdentity()) {
            $this->getRouter()->redirect(DashboardController::class);
        }
        return $this->getViewModelManager()->getViewModel([
            'viewModel' => LoginViewModel::class,
            'listeners' => [
                LoginViewModel::TRIGGER_FORMFINISH => [$this, 'onLoginFinish']
            ]
        ]);
    }

    public function onLoginFinish(\Framework\EventManager\Event $event): void
    {
        $LoginViewModel = $event->getTarget();
        $adminLogin = $LoginViewModel->getForm()->getData()['adminLogin'];
        $this->getAuthentication()->login($adminLogin['login'], $adminLogin['adminPassword']);
        $LoginModel = $this->getObjectManager()->get(LoginModel::class);
        $data       = [
            'login' => $adminLogin['login'],
        ];
        if ($this->getAuthentication()->hasIdentity()) {
            $Identity           = $this->getAuthentication()->getIdentity();
            $data['status']     = LoginModel::getPropertyValue('status', 'LOGINATTEMPTW_STATUS_SUCCESS');
            $data['adminId']    = $Identity['adminId'];
            $data['sessionId']  = $this->getSessionManager()->getId();
            $LoginAttemptW = $LoginModel->create($data);
            $this->triggerEvent(self::TRIGGER_AFTER_CREATE, $LoginAttemptW);
            $this->getRouter()->redirect(DashboardController::class);
        } else {
            $data['status'] = LoginModel::getPropertyValue('status', 'LOGINATTEMPTW_STATUS_FAILTURE');
            $LoginAttemptW = $LoginModel->create($data);
            $this->triggerEvent(self::TRIGGER_AFTER_CREATE, $LoginAttemptW);

            $Form = $LoginViewModel->getForm();
            $Form->forceError();
            $Form->adminLogin->login->setError('<span class="help-block">' . $this->getTranslator()->translate('ADMIN_CHECK_LOGIN_PASSWORD_ERROR') . '</span>');
            $Form->adminLogin->login->setErrorClass('has-error has-feedback');
        }
    }

    public static function getPageInfo(): array
    {
        return [
            "title"             => "ログイン", // title
            'description'       => "description",
            "site_name"         => "git-ski", // titleの|以降
            "lower_title"       => "", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "og_type", // og:type
            "bodyClass"         => "login-page"
        ];
    }
}
