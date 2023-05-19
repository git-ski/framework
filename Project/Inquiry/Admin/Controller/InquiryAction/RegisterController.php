<?php
/**
 * PHP version 7
 * File RegisterController.php
 *
 * @category Controller
 * @package  Project\Inquiry\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Inquiry\Admin\Controller\InquiryAction;

use Project\Base\Admin\Controller\AbstractAdminController;
use Std\ViewModel\ViewModelManager;
use Project\Inquiry\Admin\View\ViewModel\InquiryAction\RegisterViewModel;
use Project\Inquiry\Admin\Controller\InquiryAction\RegisterModel as InquiryActionRegisterModel;
use Std\SessionManager\FlashMessage;

/**
 * Class RegisterController
 *
 * @category Controller
 * @package  Project\Inquiry\Admin
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
        $inquiryAction = $ViewModel->getForm()->getData()['inquiryAction'];
        $InquiryActionRegisterModel = $this->getObjectManager()->get(InquiryActionRegisterModel::class);
        $inquiryActionEntity = $InquiryActionRegisterModel->create($inquiryAction);
        $this->getObjectManager()->get(FlashMessage::class)->add('FlashMessage', 'Created');
        $this->triggerEvent(self::TRIGGER_AFTER_CREATE, $inquiryActionEntity);
        $this->getRouter()->redirect(ListController::class);
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "title"             => "お問合せアクション登録", // title
            'description'       => "お問合せアクション登録",
            "site_name"         => "secure framework", // titleの|以降
            "lower_title"       => "", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "og_type", // og:type
            "bodyClass"         => "theme-light-blue",
            'priority'          => 2,
            'menu'              => false,
            'icon'              => '<i class="mdi mdi-av-timer fa-fw" data-icon="v"></i>',
            'group'             => 'お問合せ管理',
            'groupIcon'         => '<i class="mdi mdi-av-timer fa-fw" data-icon="v"></i>',
        ];
    }
}
