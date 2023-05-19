<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Permission\Admin\Controller\Role;

use Project\Base\Admin\Controller\AbstractAdminController;
use Std\ViewModel\ViewModelManager;
use Project\Permission\Admin\View\ViewModel\Role\DeleteViewModel;
use Std\SessionManager\FlashMessage;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class DeleteController extends AbstractAdminController
{
    /**
     * Method index
     *
     * @param integer|str $id EntityId
     *
     * @return DeleteViewModel
     */
    public function index($id): DeleteViewModel
    {
        $DeleteModel = $this->getObjectManager()->get(DeleteModel::class);
        $Role   = $DeleteModel->get($id);
        if (!$Role) {
            $this->getRouter()->redirect(ListController::class);
        }
        return $this->getViewModelManager()->getViewModel([
            'viewModel' => DeleteViewModel::class,
            'data'      => [
                'role'    => $Role,
            ],
            'listeners' => [
                DeleteViewModel::TRIGGER_FORMFINISH => [$this, 'onDeleteFinish']
            ],
        ]);
    }

    /**
     * Method onDeleteFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onDeleteFinish(\Framework\EventManager\Event $event): void
    {
        $ViewModel = $event->getTarget();
        $role = $ViewModel->getForm()->getData()['role'];
        $DeleteModel = $this->getObjectManager()->get(DeleteModel::class);
        $Role = $DeleteModel->get($role['roleId']);
        $DeleteModel->delete($Role);
        $this->triggerEvent(self::TRIGGER_AFTER_DELETE, $Role);
        $this->getObjectManager()->get(FlashMessage::class)->add('FlashMessage', 'Deleted');
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
            "title"             => "ロール削除", // title
            "description"       => "ロール削除",
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
            'priority'          => 0,
            'menu'              => false,
        ];
    }
}
