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
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use Project\OAuth2Server\Helper\Entities\ClientEntity;
use Project\OAuth2Server\Model\OauthClientModel;

class ClientRepository implements
    ObjectManagerAwareInterface,
    ClientRepositoryInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    /**
     * {@inheritdoc}
     */
    public function getClientEntity($clientIdentifier, $grantType = null, $clientSecret = null, $mustValidateSecret = true)
    {
        // クライアントが登録しているかをチェック
        $OauthClientModel = $this->getObjectManager()->get(OauthClientModel::class);
        $OauthClient = $OauthClientModel->get($clientIdentifier);
        if (!$OauthClient) {
            return;
        }
        // 秘密鍵ーが提供される場合、秘密鍵を認証する
        if (null !== $clientSecret) {
            $PasswordCrypt = $OauthClientModel->getCryptManager()->getPasswordCrypt();
            if (false === $PasswordCrypt->verify($clientSecret, $OauthClient->getPassword())) {
                return;
            }
        }
        $client = new ClientEntity();
        $client->setIdentifier($OauthClient->getOauthClientId());
        $client->setName($OauthClient->getName());
        $client->setRedirectUri($OauthClient->getRedirectUri());
        return $client;
    }
}
