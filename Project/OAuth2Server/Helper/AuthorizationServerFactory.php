<?php

namespace Project\OAuth2Server\Helper;

use Framework\ObjectManager\FactoryInterface;
use Framework\ObjectManager\ObjectManagerInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\FileService\FileServiceAwareInterface;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;
use Project\OAuth2Server\Helper\Repositories\AccessTokenRepository;
use Project\OAuth2Server\Helper\Repositories\AuthCodeRepository;
use Project\OAuth2Server\Helper\Repositories\ClientRepository;
use Project\OAuth2Server\Helper\Repositories\RefreshTokenRepository;
use Project\OAuth2Server\Helper\Repositories\ScopeRepository;
use DateInterval;

class AuthorizationServerFactory implements
    FactoryInterface,
    ConfigManagerAwareInterface,
    FileServiceAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\FileService\FileServiceAwareTrait;

    public function create(ObjectManagerInterface $ObjectManager)
    {
        $clientRepository       = $ObjectManager->get(ClientRepository::class);
        $scopeRepository        = $ObjectManager->get(ScopeRepository::class);
        $accessTokenRepository  = $ObjectManager->get(AccessTokenRepository::class);
        $authCodeRepository     = $ObjectManager->get(AuthCodeRepository::class);
        $refreshTokenRepository = $ObjectManager->get(RefreshTokenRepository::class);

        $ConfigManager  = $this->getConfigManager();
        $oauthConfig    = $ConfigManager->getConfig('oauth');

        $privateKeyPath = $oauthConfig['key']['privatePath'] ?? null;
        $encryptionKey  = $oauthConfig['encryption'] ?? null;
        $privateKeyPath = $this->getFileService()->validateFilePath($privateKeyPath);

        // 認証サーバー設定
        $server = new AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            $privateKeyPath,
            $encryptionKey
        );
        $authCodeTTL        = new DateInterval($oauthConfig['grants']['authenticationCode']);
        $accessTokenTTL     = new DateInterval($oauthConfig['grants']['accessToken']);
        $refreshTokenTTL    = new DateInterval($oauthConfig['grants']['refreshToken']);
        // authentication code 付与設定
        $AuthCodeGrant      = new AuthCodeGrant(
            $authCodeRepository,
            $refreshTokenRepository,
            $authCodeTTL
        );
        $AuthCodeGrant->setRefreshTokenTTL($refreshTokenTTL);
        $server->enableGrantType(
            $AuthCodeGrant,
            $accessTokenTTL
        );
        // refresh token 付与設定
        $RefreshTokenGrant  = new RefreshTokenGrant($refreshTokenRepository);
        $RefreshTokenGrant->setRefreshTokenTTL($refreshTokenTTL);
        $server->enableGrantType(
            $RefreshTokenGrant,
            $accessTokenTTL
        );
        return $server;
    }
}
