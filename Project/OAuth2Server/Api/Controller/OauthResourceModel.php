<?php
/**
 * PHP version 7
 * File OauthModel.php
 *
 * @category Model
 * @package  Project\OAuth2Server\Api
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\OAuth2Server\Api\Controller;

use Project\OAuth2Server\Model\OauthAccessTokenModel;
use Psr\Http\Message\ServerRequestInterface;
use Project\OAuth2Server\Helper\ResourceServerInterface;
use Project\OAuth2Server\Helper\Entities\UserEntity;

class OauthResourceModel extends OauthAccessTokenModel
{
    private $validatedRequest;

    public function validateRequest(ServerRequestInterface $Request)
    {
        $ResourceServer     = $this->getObjectManager()->get(ResourceServerInterface::class);
        try {
            $this->validatedRequest = $ResourceServer->validateAuthenticatedRequest($Request);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getValidatedRequest()
    {
        return $this->validatedRequest;
    }

    public function getValidatedOauth()
    {
        if (!$this->validatedRequest) {
            return;
        }
        $attributes = $this->validatedRequest->getAttributes();
        return [
            'accessTokenId' => $attributes['oauth_access_token_id'],
            'clientId'      => $attributes['oauth_client_id'],
            'userIdentifier'=> UserEntity::decode($attributes['oauth_user_id']),
            'scopes'        => $attributes['oauth_scopes'],
        ];
    }
}
