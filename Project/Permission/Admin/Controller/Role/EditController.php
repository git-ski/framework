<?php
/**
 * PHP version 7
 * File EditController.php
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
use Project\Permission\Admin\View\ViewModel\Role\EditViewModel;
use Std\SessionManager\FlashMessage;

/**
 * Class EditController
 *
 * @category Controller
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class EditController extends AbstractAdminController
{
    /**
     * Method index
     *
     * @param integer|str $id EntityId
     *
     * @return EditViewModel
     */
    public function index($id): EditViewModel
    {
        $EditModel = $this->getObjectManager()->get(EditModel::class);
        $Role = $EditModel->get($id);
        if (!$Role) {
            $this->getRouter()->redirect(ListController::class);
        }
        return $this->getViewModelManager()->getViewModel([
            'viewModel' => EditViewModel::class,
            'data'      => [
                'role' => $Role,
            ],
            'listeners' => [
                EditViewModel::TRIGGER_FORMFINISH => [$this, 'onEditFinish']
            ],
        ]);
    }

    /**
     * Method onEditFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onEditFinish(\Framework\EventManager\Event $event): void
    {
        $ViewModel = $event->getTarget();
        $role = $ViewModel->getForm()->getData()['role'];
        $EditModel = $this->getObjectManager()->get(EditModel::class);
        $Role = $EditModel->get($role['roleId']);
        $EditModel->update($Role, $role);
        $this->triggerEvent(self::TRIGGER_AFTER_UPDATE, $Role);

        $this->getObjectManager()->get(FlashMessage::class)->add('FlashMessage', 'Updated');
        $this->getRouter()->reload();
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "title"             => "ロール編集", // title
            "description"       => "ロール編集",
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
