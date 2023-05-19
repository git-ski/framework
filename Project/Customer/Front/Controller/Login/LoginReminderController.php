<?php
/**
 * PHP version 7
 * File LoginReminderController.php
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\Controller\Login;

use Project\Base\Front\Controller\AbstractController;
use Std\ViewModel\ViewModelManager;
use Project\Customer\Front\View\ViewModel\Login\LoginReminderViewModel;
use Project\Customer\Front\Controller\Login\LoginReminderModel;

/**
 * Class LoginReminderController
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class LoginReminderController extends AbstractController{
    /**
     * Method index
     *
     * @return LoginReminderViewModel
     */
    public function index(): LoginReminderViewModel
    {
        return $this->getViewModelManager()->getViewModel(
            [
                'viewModel' => LoginReminderViewModel::class,
                'data'      => [
                ],
                'listeners' => [
                    LoginReminderViewModel::TRIGGER_FORMFINISH => [$this, 'onLoginReminderFinish']
                ]
            ]
        );
    }

    /**
     * Method onLoginReminderFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onLoginReminderFinish(\Framework\EventManager\Event $event): void
    {
        $ViewModel  = $event->getTarget();
        $data       = $ViewModel->getForm()->getData();
        // ここでフォーム完了時処理を書く
        $LoginReminderModel      = $this->getObjectManager()->get(LoginReminderModel::class);
        $LoginReminderModel->loginReminder($data['loginReminder']);
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "description" => "Send Your Member ID", //
            "title" => "Send Your Member ID", // title
            "site_name" => "site_name", // titleの|以降
            "lower_title" => "Send Your Member ID", // マイページ系の表示タイトル
            "meta_description" => "meta_description", // description
            "meta_keywords" => "meta_keywords", // keywords
            "og_title" => "og_title", // og:title
            "og_description" => "og_description", // og:description
            "og_site_name" => "og_site_name", // og:site_name
            "og_type" => "article", // og:type
            'priority'      => 2,
            'menu'          => false,
        ];
    }
}
