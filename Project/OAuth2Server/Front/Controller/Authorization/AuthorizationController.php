<?php
/**
 * PHP version 7
 * File AuthorizationController.php
 *
 * @category Controller
 * @package  Project\OAuth2Server\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\OAuth2Server\Front\Controller\Authorization;

use Project\Base\Front\Controller\AbstractController;
use Project\Base\Front\Controller\AuthControllerInterface;
use Std\ViewModel\ViewModelManager;
use Project\OAuth2Server\Front\View\ViewModel\Authorization\AuthorizationViewModel;
use Std\SessionManager\SessionManagerAwareInterface;
use Project\OAuth2Server\Api\Controller\OauthAuthorizeController;
use Project\Base\Front\Controller\NotFoundController;

/**
 * Class AuthorizationController
 *
 * @category Controller
 * @package  Project\OAuth2Server\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class AuthorizationController extends AbstractController implements
    AuthControllerInterface,
    SessionManagerAwareInterface
{
    use \Std\SessionManager\SessionManagerAwareTrait;

    /**
     * Method index
     *
     * @return AuthorizationViewModel
     */
    public function index(): AuthorizationViewModel
    {
        $Session   = $this->getSessionManager()->getSession(OauthAuthorizeController::class);
        $authRequest = $Session['authRequest'] ?? null;
        if (empty($authRequest)) {
            $this->getRouter()->redirect(NotFoundController::class);
        }
        return $this->getViewModelManager()->getViewModel(
            [
                'viewModel' => AuthorizationViewModel::class,
                'data'      => [
                    'authRequest' => $authRequest
                    // 'scopes' => $authRequest->getScopes()
                ],
                'listeners' => [
                    AuthorizationViewModel::TRIGGER_FORMFINISH => [$this, 'onAuthorizationFinish']
                ]
            ]
        );
    }

    /**
     * Method onAuthorizationFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onAuthorizationFinish(\Framework\EventManager\Event $event): void
    {
        $ViewModel = $event->getTarget();
        $data      = $ViewModel->getForm()->getData();
        // ここでフォーム完了時処理を書く
        $Session   = $this->getSessionManager()->getSession(OauthAuthorizeController::class);
        $Session['Approved'] = $data['authorization']['approve'] === '許可' ? true : false;
        $this->getRouter()->redirectBack();
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "description"   => "Oauth認可",
            "title"         => "Oauth認可",
            "site_name"     => "site_name", // titleの|以降
            "lower_title"   => "Oauth認可",
            "meta_description" => "meta_description",
            "meta_keywords" => "meta_keywords",
            "og_title"      => "og_title",
            "og_description"=> "og_description",
            "og_site_name"  => "og_site_name",
            "og_type"       => "article",
            'priority'      => 2,
            'menu'          => false,
        ];
    }
}
