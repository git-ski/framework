<?php
declare(strict_types=1);

namespace Project\Customer\Front\Controller\Login;

use Project\Base\Front\Controller\AbstractController;
use Std\ViewModel\ViewModelManager;
use Project\Customer\Front\View\ViewModel\Login\LoginPasswordViewModel;
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;
use Project\Customer\Front\Controller\Customer\ProfileController;
use Std\SessionManager\SessionManagerAwareInterface;
use Project\Customer\Front\Controller\Login\LoginModel as CustomerLoginModel;

class LoginPasswordController extends AbstractController implements
    AuthenticationAwareInterface,
    SessionManagerAwareInterface
{
    use \Std\Authentication\AuthenticationAwareTrait;
    use \Std\SessionManager\SessionManagerAwareTrait;

    public function index(): LoginPasswordViewModel
    {
        if ($this->getAuthentication()->hasIdentity()) {
            $this->getRouter()->redirect(ProfileController::class);
        }
        $Session = $this->getSessionManager()->getSession(LoginController::LOGIN);
        if (null === $Session->login) {
            $this->getRouter()->redirect(LoginController::class);
        }

        return $this->getViewModelManager()->getViewModel([
            'viewModel' => LoginPasswordViewModel::class,
            'data'=>[
                'login' => $Session->login
            ],
            'listeners' => [
                LoginPasswordViewModel::TRIGGER_FORMFINISH => [$this, 'onLoginFinish']
            ]
        ]);
    }

    public function onLoginFinish(\Framework\EventManager\Event $event): void
    {
        $LoginViewModel = $event->getTarget();
        $customerLogin = $LoginViewModel->getForm()->getData()['customerLoginPassword'];
        $Result = $this->getAuthentication()->login(
            $customerLogin['login'],
            $customerLogin['customerPassword'],
            $customerLogin['remberMe'] ?? null
        );
        $CustomerLoginModel = $this->getObjectManager()->get(CustomerLoginModel::class);
        $data       = [
            'login' => $customerLogin['login'],
        ];
        $Session = $this->getSessionManager()->getSession(LoginController::LOGIN);
        if ($this->getAuthentication()->hasIdentity()) {
            $Session->login = null;

            $Identity           = $this->getAuthentication()->getIdentity();
            $data['status']     = CustomerLoginModel::getPropertyValue('status', 'CUSTOMERLOGINATTEMPTW_STATUS_SUCCESS');
            $data['customerId'] = $Identity['customerId'];
            $data['sessionId']  = $this->getSessionManager()->getId();
            $CustomerLoginAttemptW = $CustomerLoginModel->create($data);
            $this->triggerEvent(self::TRIGGER_AFTER_CREATE, $CustomerLoginAttemptW);
            $this->getRouter()->redirectBack();
            $this->getRouter()->redirect(ProfileController::class);
        } else {
            $data['status'] = CustomerLoginModel::getPropertyValue('status', 'CUSTOMERLOGINATTEMPTW_STATUS_FAILTURE');
            $CustomerLoginAttemptW = $CustomerLoginModel->create($data);
            $this->triggerEvent(self::TRIGGER_AFTER_CREATE, $CustomerLoginAttemptW);

            $Form = $LoginViewModel->getForm();
            $Form->forceError();
            $Form->customerLoginPassword->login->setError('<p class="txt-error">' . $this->getTranslator()->translate('FRONT_CHECK_LOGIN_PASSWORD_ERROR') . '</p>');
            $Form->customerLoginPassword->login->setErrorClass('has-error has-feedback');
        }
    }

    public static function getPageInfo(): array
    {
        return [
            "description" => "Password ", //
            "title" => "Password ", // title
            "site_name" => "site_name", // titleの|以降
            "lower_title" => "Password ", // マイページ系の表示タイトル
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
