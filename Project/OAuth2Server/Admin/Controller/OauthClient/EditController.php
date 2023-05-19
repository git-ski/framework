<?php
/**
 * PHP version 7
 * File EditController.php
 *
 * @category Controller
 * @package  Project\OAuth2Server\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\OAuth2Server\Admin\Controller\OauthClient;

use Project\Base\Admin\Controller\AbstractAdminController;
use Std\ViewModel\ViewModelManager;
use Project\OAuth2Server\Admin\View\ViewModel\OauthClient\EditViewModel;
use Project\OAuth2Server\Admin\Controller\OauthClient\EditModel as OauthClientEditModel;
use Std\SessionManager\FlashMessage;

/**
 * Class EditController
 *
 * @category Controller
 * @package  Project\OAuth2Server\Admin
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
        $OauthClientEditModel = $this->getObjectManager()->get(OauthClientEditModel::class);
        $OauthClient = $OauthClientEditModel->get($id);
        if (!$OauthClient) {
            $this->getRouter()->redirect(ListController::class);
        }
        return $this->getViewModelManager()->getViewModel([
            'viewModel' => EditViewModel::class,
            'data'      => [
                'oauthClient' => $OauthClient,
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
        $oauthClient = $ViewModel->getForm()->getData()['oauthClient'];
        $OauthClientEditModel = $this->getObjectManager()->get(OauthClientEditModel::class);
        $OauthClient = $OauthClientEditModel->get($oauthClient['oauthClientId']);
        $OauthClientEditModel->update($OauthClient, $oauthClient);
        $this->getObjectManager()->get(FlashMessage::class)->add('FlashMessage', 'Updated');
        $this->triggerEvent(self::TRIGGER_AFTER_UPDATE, $OauthClient);
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
            "title"             => "OauthClient 編集", // title
            'description'       => "OauthClient 編集",
            "site_name"         => "secure framework", // titleの|以降
            "lower_title"       => "", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "og_type", // og:type
            "bodyClass"         => "theme-light-blue",
            'priority'          => 0,
            'menu'              => false,
        ];
    }
}
