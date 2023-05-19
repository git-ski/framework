<?php
/**
 * PHP version 7
 * File RegisterController.php
 *
 * @category Controller
 * @package  Project\AdminUser\Admin
 * @author   gitski
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\AdminUser\Admin\Controller\AdminUser;

use Project\Base\Admin\Controller\AbstractAdminController;
use Std\ViewModel\ViewModelManager;
use Project\AdminUser\Admin\View\ViewModel\AdminUser\RegisterViewModel;
use Std\SessionManager\FlashMessage;

/**
 * Class RegisterController
 *
 * @category Controller
 * @package  Project\AdminUser\Admin
 * @author   gitski
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
        $ViewModel          = $event->getTarget();
        $admin              = $ViewModel->getForm()->getData()['admin'];
        $RegisterModel      = $this->getObjectManager()->get(RegisterModel::class);
        $adminEntity        = $RegisterModel->create($admin);
        $this->triggerEvent(self::TRIGGER_AFTER_CREATE, $adminEntity);
        $this->getObjectManager()->get(FlashMessage::class)->add('FlashMessage', 'Created');
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
            "title"             => "管理者登録", // title
            "description"       => "管理者登録",
            "site_name"         => "git-ski", // titleの|以降
            "lower_title"       => "", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "og_type", // og:type
            "bodyClass"         => "theme-light-blue",
            'group'             => '管理者管理',
            'priority'          => 2,
            'menu'              => false,
        ];
    }
}
