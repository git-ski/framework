<?php
/**
 * PHP version 7
 * File OauthAccessTokenController.php
 *
 * @category Controller
 * @package  Project\OAuth2Server\Api
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\OAuth2Server\Api\Controller;

use Framework\Application\ApplicationInterface;
use Project\Base\Api\Controller\AbstractRestfulController;
use Project\OAuth2Server\Api\Fieldset;
use Project\OAuth2Server\Helper\AuthorizationServerInterface;
use Project\OAuth2Server\Api\Controller\OauthAccessTokenModel;
use League\OAuth2\Server\Exception\OAuthServerException;
use Exception;

/**
 * curl 'https://docker.local/rest/v1/oauth/access_token' -H 'accept: text/json' --data 'grant_type=authorization_code&client_id=2&client_secret=cc8428d5a65a8c18&redirect_uri=https://localhost/rest/v1/oauth/test&code={code}' --insecure
 * refresh
 * curl 'https://docker.local/rest/v1/oauth/access_token' -H 'accept: text/json' --data 'grant_type=refresh_token&client_id=2&client_secret=cc8428d5a65a8c18&refresh_token={token}' --insecure
 */
class OauthAccessTokenController extends AbstractRestfulController
{
    /**
     * 登録
     *
     * @param array $data
     * @return array レスポンス
     */
    public function create($data)
    {
        $HttpMessageManager  = $this->getHttpMessageManager();
        $AuthorizationServer = $this->getObjectManager()->get(AuthorizationServerInterface::class);
        $Request = $HttpMessageManager->getRequest();
        $Response = $HttpMessageManager->getResponse();
        try {
            $Response = $AuthorizationServer->respondToAccessTokenRequest($Request, $Response);
        } catch (OAuthServerException $exception) {
            $Response = $exception->generateHttpResponse($Response);
        } catch (Exception $exception) {
            $Response->getBody()->write($exception->getMessage());
            $Response = $Response->withStatus(500);
        }
        $HttpMessageManager->setResponse($Response);
        $HttpMessageManager->sendResponse();
        $this->getObjectManager()->get(ApplicationInterface::class)->exit();
    }
}
