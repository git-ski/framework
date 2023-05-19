<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace Project\OAuth2Server\Helper\Repositories;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use Project\OAuth2Server\Helper\Entities\ScopeEntity;
use Framework\ConfigManager\ConfigManagerAwareInterface;

class ScopeRepository implements
    ScopeRepositoryInterface,
    ConfigManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function getScopeEntityByIdentifier($scopeIdentifier)
    {
        $scopes = $this->getConfigManager()->getConfig('oauth.scopes');
        $scope  = $scopes[$scopeIdentifier] ?? null;
        if (null === $scope) {
            return ;
        }

        $ScopeEntity = new ScopeEntity();
        $ScopeEntity->setIdentifier($scopeIdentifier);
        $ScopeEntity->setDescription($scope['description'] ?? null);
        return $ScopeEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ) {
         (例あり)
        // if ((int) $userIdentifier === 1) {
        //     $scope = new ScopeEntity();
        //     $scope->setIdentifier('email');
        //     $scopes[] = $scope;
        // }

        return $scopes;
    }
}
