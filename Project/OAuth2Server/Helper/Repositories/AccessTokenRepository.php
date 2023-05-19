<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace Project\OAuth2Server\Helper\Repositories;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use Project\OAuth2Server\Helper\Entities\AccessTokenEntity;
use Project\OAuth2Server\Model\OauthClientModel;
use Project\OAuth2Server\Model\OauthAccessTokenModel;
use Project\OAuth2Server\Helper\Entities\UserEntity;
use Project\AdminUser\Model\AdminModel;
use Project\Customer\Model\CustomerModel;

class AccessTokenRepository implements
    ObjectManagerAwareInterface,
    AccessTokenRepositoryInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    /**
     * {@inheritdoc}
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $clientId = $accessTokenEntity->getClient()->getIdentifier();
        $OauthAccessTokenModel = $this->getObjectManager()->get(OauthAccessTokenModel::class);
        $UserIdentifier = UserEntity::decode($accessTokenEntity->getUserIdentifier());
        $type = $UserIdentifier['type'] ?? null;
        $id   = $UserIdentifier['id'] ?? null;
        $condition = [];
        switch ($type) {
            case 'customer':
                $CustomerModel = $this->getObjectManager()->get(CustomerModel::class);
                $condition['Customer'] = $CustomerModel->get($id);
                break;
            case 'admin':
                $AdminModel = $this->getObjectManager()->get(AdminModel::class);
                $condition['Admin'] = $AdminModel->get($id);
                break;
        }
        if (empty($condition)) {
            return;
        }
        $OauthClientModel = $this->getObjectManager()->get(OauthClientModel::class);
        $condition['OauthClient'] = $OauthClientModel->get($clientId);
        $OauthToken = $OauthAccessTokenModel->getOneBy($condition);
        $scopes     = array_map(function ($scope) {
            return $scope->getIdentifier();
        }, $accessTokenEntity->getScopes());
        if ($OauthToken) {
            $OauthAccessTokenModel->update($OauthToken, [
                'accessToken'       => $accessTokenEntity->getIdentifier(),
                'scopes'            => join(',', $scopes),
                'expiryDatetime'    => $accessTokenEntity->getExpiryDateTime()->format('Y-m-d H:i:s')
            ]);
        } else {
            $OauthAccessTokenModel->create($condition + [
                'accessToken'       => $accessTokenEntity->getIdentifier(),
                'scopes'            => join(',', $scopes),
                'expiryDatetime'    => $accessTokenEntity->getExpiryDateTime()->format('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAccessToken($tokenId)
    {
        // Some logic here to revoke the access token
    }

    /**
     * {@inheritdoc}
     */
    public function isAccessTokenRevoked($tokenId)
    {
        return false; // Access token hasn't been revoked
    }

    /**
     * {@inheritdoc}
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessTokenEntity();
        $accessToken->setClient($clientEntity);
        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }
        $accessToken->setUserIdentifier($userIdentifier);

        return $accessToken;
    }
}
