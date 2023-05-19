<?php

namespace Project\OAuth2Server\Helper;

use Framework\ObjectManager\FactoryInterface;
use Framework\ObjectManager\ObjectManagerInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\FileService\FileServiceAwareInterface;
use League\OAuth2\Server\ResourceServer;
use Project\OAuth2Server\Helper\Repositories\AccessTokenRepository;

class ResourceServerFactory implements
    FactoryInterface,
    ConfigManagerAwareInterface,
    FileServiceAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\FileService\FileServiceAwareTrait;

    public function create(ObjectManagerInterface $ObjectManager)
    {
        $accessTokenRepository  = $ObjectManager->get(AccessTokenRepository::class);

        $ConfigManager  = $this->getConfigManager();
        $oauthConfig    = $ConfigManager->getConfig('oauth');

        $publicKeyPath = $oauthConfig['key']['publicPath'] ?? null;
        $publicKeyPath = $this->getFileService()->validateFilePath($publicKeyPath);

        // リソースサーバー設定
        $server = new ResourceServer(
            $accessTokenRepository,
            $publicKeyPath
        );
        return $server;
    }
}
