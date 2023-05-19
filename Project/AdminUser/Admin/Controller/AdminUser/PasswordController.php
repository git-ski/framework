<?php
/**
 * PHP version 7
 * File EditController.php
 *
 * @category Controller
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\AdminUser\Admin\Controller\AdminUser;

use Project\Base\Admin\Controller\AbstractAdminController;
use Std\ViewModel\ViewModelManager;
use Project\AdminUser\Admin\View\ViewModel\AdminUser\PasswordViewModel;
use Project\AdminUser\Admin\Authentication\AuthenticationAwareInterface;
use Std\SessionManager\FlashMessage;

/**
 * Class EditController
 *
 * @category Controller
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class PasswordController extends AbstractAdminController implements
    AuthenticationAwareInterface
{
    use \Std\Authentication\AuthenticationAwareTrait;

    /**
     * Method index
     *
     * @param integer|str $id EntityId
     *
     * @return PasswordViewModel
     */
    public function index(): PasswordViewModel
    {
        $identity = $this->getAuthentication()->getIdentity();
        $PasswordModel = $this->getObjectManager()->get(PasswordModel::class);
        $Admin = $PasswordModel->get($identity['adminId']);
        if (!$Admin) {
            $this->getRouter()->redirect(ListController::class);
        }
        return $this->getViewModelManager()->getViewModel([
            'viewModel' => PasswordViewModel::class,
            'data'      => [
                'admin' => $Admin,
            ],
            'listeners' => [
                PasswordViewModel::TRIGGER_FORMFINISH => [$this, 'onEditFinish']
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
        $ViewModel                  = $event->getTarget();
        $admin                      = $ViewModel->getForm()->getData()['admin'];
        $PasswordModel = $this->getObjectManager()->get(PasswordModel::class);
        $Admin = $PasswordModel->get($admin['adminId']);
        $PasswordModel->update($Admin, $admin);
        $this->getAuthentication()->updateIdentity(['tempPasswordFlag' => 0]);
        $this->triggerEvent(self::TRIGGER_AFTER_UPDATE, $Admin);
        $this->getObjectManager()->get(FlashMessage::class)->add('FlashMessage', 'Admin Changed');
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
            "title"             => "パスワード変更", // title
            "description"       => "パスワード変更",
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
