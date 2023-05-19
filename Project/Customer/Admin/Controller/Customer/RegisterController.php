<?php
/**
 * PHP version 7
 * File RegisterController.php
 *
 * @category Controller
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Admin\Controller\Customer;

use Project\Base\Admin\Controller\AbstractAdminController;
use Std\ViewModel\ViewModelManager;
use Project\Customer\Admin\View\ViewModel\Customer\RegisterViewModel;
use Project\Customer\Admin\Controller\Customer\RegisterModel as CustomerRegisterModel;
use Std\SessionManager\FlashMessage;

/**
 * Class RegisterController
 *
 * @category Controller
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RegisterController extends AbstractAdminController
{
    /**
     * Method index
     *
     * @return RegisterViewModel
     */
    public function index(): RegisterViewModel
    {

        return $this->getViewModelManager()->getViewModel(
            [
                'viewModel' => RegisterViewModel::class,
                'data'      => [
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
        $ViewModel = $event->getTarget();
        $customer = $ViewModel->getForm()->getData()['customer'];
        $CustomerRegisterModel = $this->getObjectManager()->get(CustomerRegisterModel::class);
        $customerEntity = $CustomerRegisterModel->create($customer);

        $this->getObjectManager()->get(FlashMessage::class)->add('FlashMessage', 'Created');

        $this->triggerEvent(self::TRIGGER_AFTER_CREATE, $customerEntity);
        $this->getRouter()->redirect(ListController::class, null, ['search'=>1]);
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "title"             => "顧客登録", // title
            'description'       => "顧客登録",
            "site_name"         => "secure framework", // titleの|以降
            "lower_title"       => "", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "og_type", // og:type
            "bodyClass"         => "theme-light-blue",
            'priority'          => 32,
            'menu'              => true,
            'icon'              => '<i class="mdi mdi-play fa-fw" data-icon="v"></i>',
            'group'             => '顧客管理',
            'groupIcon'         => '<i class="mdi mdi-menu fa-fw" data-icon="v"></i>',
        ];
    }
}
