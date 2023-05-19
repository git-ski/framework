<?php
declare(strict_types=1);

namespace Project\AdminUser\Admin\Authentication;

use Std\Authentication\AbstractAuthentication;
use Laminas\Authentication\Result;
use Laminas\Authentication\Storage;
use Laminas\Authentication\Adapter;
use Std\RouterManager\RouterAwareInterface;
use Project\AdminUser\Admin\Authentication\Adapter\Admin;

class Authentication extends AbstractAuthentication
{
    public function __construct(Storage\StorageInterface $Storage = null, Adapter\AdapterInterface $Adapter = null)
    {
        if ($Adapter === null) {
            $Adapter = $this->getObjectManager()->create(Admin::class);
        }
        parent::__construct($Storage, $Adapter);
    }

    public function login($username, $password)
    {
        $Adapter = $this->getAdapter();
        $Adapter->setUsername($username);
        $Adapter->setPassword($password);
        $result = $this->authenticate($Adapter);
        if ($result->isValid()) {
            $ZfSessionManager = $this->getSessionManager()->getSessionManager();
            $ZfSessionManager->regenerateId();
            $this->triggerEvent(self::TRIGGER_AUTHENTICATE);
        }
        return $result;
    }
}
