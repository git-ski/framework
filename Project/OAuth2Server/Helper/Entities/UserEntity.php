<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace Project\OAuth2Server\Helper\Entities;

use League\OAuth2\Server\Entities\UserEntityInterface;
use Framework\ObjectManager\ObjectManager;
use Project\AdminUser\Model\AdminModel;
use Project\Customer\Model\CustomerModel;
use Project\AdminUser\Entity\Admin;
use Project\Customer\Entity\Customer;

class UserEntity implements UserEntityInterface
{
    private $Identity;
    private $User;

    public function __construct($Identity)
    {
        $this->Identity = $Identity;
    }
    /**
     * Return the user's identifier.
     *
     * @return mixed
     */
    public function getIdentifier()
    {
        $User = $this->getUser();
        if ($User instanceof Admin) {
            return self::encode([
                'type'    => 'admin',
                'id'      => $User->getAdminId()
            ]);
        }
        if ($User instanceof Customer) {
            return self::encode([
                'type'    => 'customer',
                'id'      => $User->getCustomerId()
            ]);
        }
    }

    private function getUser()
    {
        if (null === $this->User) {
            $Identity = $this->Identity;
            $ObjectManager = ObjectManager::getSingleton();
            if (isset($Identity['adminId'])) {
                $this->User = $ObjectManager->get(AdminModel::class)->get($Identity['adminId']);
            }
            if (isset($Identity['customerId'])) {
                $this->User = $ObjectManager->get(CustomerModel::class)->get($Identity['customerId']);
            }
        }
        return $this->User;
    }

    public static function encode($identity)
    {
        return json_encode($identity);
    }

    public static function decode($encodedIdentity)
    {
        return json_decode($encodedIdentity, true);
    }
}
