<?php
/**
 * PHP version 7
 * File OauthAuthorizeController.php
 *
 * @category Controller
 * @package  Project\OAuth2Server\Api
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\OAuth2Server\Api\Controller;

use Project\Base\Api\Controller\AbstractRestfulController;
use Project\OAuth2Server\Helper\Entities\UserEntity;
use Project\OAuth2Server\Api\Controller\OauthAuthorizeModel;
use Project\OAuth2Server\Helper\AuthorizationServerInterface;
use Project\OAuth2Server\Front\Controller\Authorization\AuthorizationController;
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;
use Project\Customer\Front\Controller\Login\LoginController;
use Std\SessionManager\SessionManagerAwareInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use Laminas\Diactoros\Response\RedirectResponse;
use Framework\Application\ApplicationInterface;

/**
 * test: https://docker.local/rest/v1/oauth/authorize?client_id=2&redirect_uri=https://localhost/rest/v1/oauth/test&response_type=code&scope=basic email
 */
class OauthAuthorizeController extends AbstractRestfulController implements
    AuthenticationAwareInterface,
    SessionManagerAwareInterface
{
    use \Std\Authentication\AuthenticationAwareTrait;
    use \Std\SessionManager\SessionManagerAwareTrait;

    /**
     * 参照(複数)
     *
     * @param array $data 検索条件
     * @return array レスポンス
     */
    public function getList()
    {
        $HttpMessageManager  = $this->getHttpMessageManager();
        $AuthorizationServer = $this->getObjectManager()->get(AuthorizationServerInterface::class);
        $Request    = $HttpMessageManager->getRequest();
        $Response   = $HttpMessageManager->getResponse();
        $Session    = $this->getSessionManager()->getSession(static::class);
        try {
            // Oauthサーバーに、リクエストをバリデーションする
            // この後、何回も画面遷移が発生するので、バリデーション済みのリクエストをセッションに置いて使い回す。
            if (isset($Session['authRequest'])) {
                $authRequest = $Session['authRequest'];
            } else {
                $authRequest = $AuthorizationServer->validateAuthorizationRequest($Request);
                $Session['authRequest'] = $authRequest;
            }
            // ログインしていない場合は、ログインさせる。
            if (!$this->getAuthentication()->hasIdentity()) {
                $this->getRouter()->redirect(LoginController::class, null, [], $pushHistory = true);
            }
            $Approved = $Session['Approved'] ?? null;
            // ユーザーがリクエストを許可か拒否していないのであれば、認可画面に飛ばして確認させる。
            if (null === $Approved) {
                $this->getRouter()->redirect(AuthorizationController::class, null, [], $pushHistory = true);
            }
            // ユーザー情報、及びリクエストに対する許可・拒否情報をセットする。
            $Identity = $this->getAuthentication()->getIdentity();
            $authRequest->setUser(new UserEntity($Identity));
            $authRequest->setAuthorizationApproved($Approved);
            // レスポンスを準備する。
            $Response = $AuthorizationServer->completeAuthorizationRequest($authRequest, new RedirectResponse(''));
        } catch (OAuthServerException $exception) {
            $Response = $exception->generateHttpResponse($Response);
        } catch (\Exception $exception) {
            $Response->getBody()->write($exception->getMessage());
            $Response = $Response->withStatus(500);
        }
        $HttpMessageManager->setResponse($Response);
        $HttpMessageManager->sendResponse();
        $this->getObjectManager()->get(ApplicationInterface::class)->exit();
    }
}
