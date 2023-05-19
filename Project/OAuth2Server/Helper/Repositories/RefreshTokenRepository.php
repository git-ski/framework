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
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use Project\OAuth2Server\Helper\Entities\RefreshTokenEntity;
use Project\OAuth2Server\Model\OauthClientModel;
use Project\OAuth2Server\Model\OauthAccessTokenModel;
use Project\OAuth2Server\Model\OauthRefreshTokenModel;
use Project\OAuth2Server\Helper\Entities\UserEntity;
use Project\AdminUser\Model\AdminModel;
use Project\Customer\Model\CustomerModel;

class RefreshTokenRepository implements
    RefreshTokenRepositoryInterface,
    ObjectManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        $accessTokenEntity = $refreshTokenEntity->getAccessToken();
        $accessToken = $accessTokenEntity->getIdentifier();
        $OauthAccessTokenModel = $this->getObjectManager()->get(OauthAccessTokenModel::class);
        $OauthAccessToken = $OauthAccessTokenModel->getOneBy([
            'accessToken' => $accessToken
        ]);
        $OauthRefreshTokenModel = $this->getObjectManager()->get(OauthRefreshTokenModel::class);

        $OauthRefreshTokenModel->create([
            'OauthAccessToken'  => $OauthAccessToken,
            'refreshToken'      => $refreshTokenEntity->getIdentifier(),
            'expiryDatetime'    => $refreshTokenEntity->getExpiryDateTime()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function revokeRefreshToken($tokenId)
    {
        // Some logic to revoke the refresh token in a database
    }

    /**
     * {@inheritdoc}
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        return false; // The refresh token has not been revoked
    }

    /**
     * {@inheritdoc}
     */
    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity();
    }
}
