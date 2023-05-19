<?php
/**
 * PHP version 7
 * File ConfigurationController.php
 *
 * @category Controller
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Permission\Admin\Controller\Permission;

use Project\Base\Admin\Controller\AbstractAdminController;
use Std\ViewModel\ViewModelManager;
use Project\Permission\Admin\View\ViewModel\Permission\ConfigurationViewModel;
use Project\Permission\Admin\Controller\Permission\ConfigurationModel as PermissionConfigurationModel;

/**
 * Class ConfigurationController
 *
 * @category Controller
 * @package  Project\Permission\Admin
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
        $PermissionConfigurationModel = $this->getObjectManager()->get(PermissionConfigurationModel::class);
        return $this->getViewModelManager()->getViewModel(
            [
                'viewModel' => ConfigurationViewModel::class,
                'data'      => [
                    'configuration' => [
                        'permission' => $PermissionConfigurationModel->getMatrix(),
                    ],
                    'model'    => $PermissionConfigurationModel
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
        $matrix    = $data['configuration']['permission'] ?? [];
        $PermissionConfigurationModel = $this->getObjectManager()->get(PermissionConfigurationModel::class);
        $PermissionConfigurationModel->updateMatrix($matrix);
        $this->triggerEvent(self::TRIGGER_AFTER_UPDATE);
        $this->getRouter()->redirect(self::class);
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "title"             => "権限設定", // title
            "description"       => "権限設定",
            "site_name"         => "git-ski", // titleの|以降
            "lower_title"       => "", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "og_type", // og:type
            "bodyClass"         => "theme-light-blue",
            'priority'          => 54,
            'menu'              => true,
            'icon'              => '<i class="mdi mdi-play fa-fw" data-icon="v"></i>',
            'group'             => '管理者管理',
            'groupIcon'         => '<i class="mdi mdi-menu fa-fw" data-icon="v"></i>',
        ];
    }
}
