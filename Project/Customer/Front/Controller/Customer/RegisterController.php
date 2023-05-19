<?php
/**
 * PHP version 7
 * File RegisterController.php
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author   gitski
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\Controller\Customer;

use Project\Base\Front\Controller\AbstractController;
use Std\ViewModel\ViewModelManager;
use Project\Customer\Front\View\ViewModel\Customer\RegisterViewModel;
use Project\Customer\Front\Controller\Customer\RegisterModel as CustomerRegisterModel;
use Project\Customer\Front\Controller\Customer\ProvisionalModel as CustomerProvisionalModel;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Project\Customer\Config;
use Project\Language\LocaleDetector\Front;
use Project\Base\Model\CountryModel;
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;
use Project\Customer\Front\Controller\Login\LoginModel as CustomerLoginModel;
use Std\SessionManager\SessionManagerAwareInterface;
use Project\Customer\Front\Controller\Customer\ProfileController;

/**
 * Class RegisterController
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author   gitski
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RegisterController extends AbstractController implements
    ConfigManagerAwareInterface,
    AuthenticationAwareInterface,
    SessionManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\Authentication\AuthenticationAwareTrait;
    use \Std\SessionManager\SessionManagerAwareTrait;
    /**
     * Method index
     *
     * @return RegisterViewModel
     */
    public function index(): RegisterViewModel
    {
        if ($this->getAuthentication()->hasIdentity()) {
            $this->getRouter()->redirect(ProfileController::class);
        }
        $h = $this->getHttpMessageManager()->getRequest()->getQueryParams()['h'] ?? null;
        $CustomerProvisionalModel = $this->getObjectManager()->get(CustomerProvisionalModel::class);
        $registerExpiration = $this->getConfigManager()->getConfig(Config::class)['registerExpiration'];
        if (!$h || !$CustomerProvisional = $CustomerProvisionalModel->getOneByHashKey($h, $registerExpiration)) {
            $this->getRouter()->redirect(ProvisionalController::class);
        }
        return $this->getViewModelManager()->getViewModel(
            [
                'viewModel' => RegisterViewModel::class,
                'data'      => [
                    'customer' => $CustomerProvisional,
                ],
                'listeners' => [
                    RegisterViewModel::TRIGGER_FORMFINISH => [$this, 'onRegisterFinish']
                ]
            ]
        );
    }

    /**
     * Method onRegisterFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onRegisterFinish(\Framework\EventManager\Event $event): void
    {
        $ViewModel             = $event->getTarget();
        $dataViewModel         = $ViewModel->getData();
        $customer              = $ViewModel->getForm()->getData()['customer'];
        $customerPassword      = $ViewModel->getForm()->getData()['customer']['customerPassword'];
        $CustomerRegisterModel = $this->getObjectManager()->get(CustomerRegisterModel::class);
        $result = $CustomerRegisterModel->create($customer);
        if ($result) {
            $this->getAuthentication()->login(
                $result->getLogin(),
                $customerPassword
            );
            $CustomerLoginModel = $this->getObjectManager()->get(CustomerLoginModel::class);
            $data = [
                'login' =>  $result->getLogin(),
            ];
            if ($this->getAuthentication()->hasIdentity()) {
                $Identity = $this->getAuthentication()->getIdentity();
                $data['status'] = CustomerLoginModel::getPropertyValue('status', 'CUSTOMERLOGINATTEMPTW_STATUS_SUCCESS');
                $data['customerId'] = $Identity['customerId'];
                $data['sessionId'] = $this->getSessionManager()->getId();
                $CustomerLoginModel->create($data);
                $CustomerTemporary = $dataViewModel['customer'];
                $dataViewModel['redirectToUrl'] = $CustomerTemporary->getRedirectTo();
                $ViewModel->setData($dataViewModel);
            } else {
                $data['status'] = CustomerLoginModel::getPropertyValue('status', 'CUSTOMERLOGINATTEMPTW_STATUS_FAILTURE');
                $CustomerLoginModel->create($data);
            }
        }
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "description"       => "Create an Account", //
            "title"             => "Create an Account", // title
            "site_name"         => "site_name", // titleの|以降
            "lower_title"       => "Create an Account", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "article", // og:type
            'bodyId'            => 'mypage',
            'priority'          => 0,
            'menu'              => false
        ];
    }
}
