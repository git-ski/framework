<?php
declare(strict_types=1);

namespace Project\Customer\Front\Authentication;

use Std\Authentication\AbstractAuthentication;
use Laminas\Authentication\Storage;
use Laminas\Authentication\Adapter;
use Project\Customer\Front\Authentication\Adapter\Customer;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\SessionManager\SessionManagerAwareInterface;

class Authentication extends AbstractAuthentication implements
    ConfigManagerAwareInterface,
    SessionManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\SessionManager\SessionManagerAwareTrait;

    const AUTO_LOGIN = 7 * 24 * 3600;

    public function __construct(Storage\StorageInterface $Storage = null, Adapter\AdapterInterface $Adapter = null)
    {
        if ($Adapter === null) {
            $Adapter = $this->getObjectManager()->create(Customer::class);
        }
        parent::__construct($Storage, $Adapter);
    }

    public function login($username, $password, $remberme = null)
    {
        $Adapter = $this->getAdapter();
        $Adapter->setUsername($username);
        $Adapter->setPassword($password);
        $result = $this->authenticate($Adapter);
        if ($result->isValid()) {
            // 「ログインのままにする」のであれば
            $ZfSessionManager = $this->getSessionManager()->getSessionManager();
            $ZfSessionManager->regenerateId();
            if ($remberme) {
                $sessionConfig  = $this->getConfigManager()->getConfig('session');
                $autoLogin      = $sessionConfig['authentication']['auto_login'] ?? self::AUTO_LOGIN;
                $ZfSessionManager->rememberMe($autoLogin);
            }
            $this->triggerEvent(self::TRIGGER_AUTHENTICATE);
        }
        return $result;
    }
}
