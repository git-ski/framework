<?php
/**
 * PHP version 7
 * File ConfigurationController.php
 *
 * @category Controller
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\AdminUser\Admin\Controller\Configuration;

use Project\Base\Admin\Controller\AbstractAdminController;
use Std\ViewModel\ViewModelManager;
use Project\AdminUser\Admin\View\ViewModel\Configuration\ConfigurationViewModel;

/**
 * Class ConfigurationController
 *
 * @category Controller
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ConfigurationController extends AbstractAdminController
{
    /**
     * Method index
     *
     * @return ConfigurationViewModel
     */
    public function index(): ConfigurationViewModel
    {
        return $this->getViewModelManager()->getViewModel(
            [
                'viewModel' => ConfigurationViewModel::class,
                'data'      => [
                ],
                'listeners' => [
                    ConfigurationViewModel::TRIGGER_FORMFINISH => [$this, 'onConfigurationFinish']
                ]
            ]
        );
    }

    /**
     * Method onConfigurationFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onConfigurationFinish(\Framework\EventManager\Event $event): void
    {
        $ViewModel = $event->getTarget();
        $data      = $ViewModel->getForm()->getData();
        // ここでフォーム完了時処理を書く

    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "title"             => "管理画面設定", // title
            "description"       => "管理画面設定",
            "site_name"         => "secure framework", // titleの|以降
            "lower_title"       => "", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "og_type", // og:type
            "bodyClass"         => "theme-light-blue",
            'priority'          => 98,
            'menu'              => true,
            'icon'              => '<i class="mdi mdi-av-timer fa-fw" data-icon="v"></i>',
            'group'             => '管理者管理',
            'groupIcon'         => '<i class="mdi mdi-av-timer fa-fw" data-icon="v"></i>',
        ];
    }
}
