<?php
declare(strict_types=1);

namespace Project\AdminUser\Admin\Authentication\Adapter;

use Std\Authentication\Adapter\AbstractAdapter;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\EntityManager\EntityManagerInterface;
use Project\AdminUser\Entity\Admin as AdminEntity;
use Laminas\Authentication\Result;
use Laminas\Crypt\Password\PasswordInterface;

class Admin extends AbstractAdapter implements ObjectManagerAwareInterface
{
    const PASSWORD_TYPE = 'Bcrypt';

    use \Framework\ObjectManager\ObjectManagerAwareTrait;

    public function authenticate()
    {
        $Admin = $this->getAdminUser();
        if ($Admin && $this->getCrypt()->verify($this->password, $Admin->getAdminPassword())) {
            return new Result(Result::SUCCESS, $Admin->toArray(), ['Authenticated successfully.']);
        } else {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ['Invalid credentials.']);
        }
    }

    public function getAdminUser()
    {
        $AdminRepository = $this->getEntityManager()->getRepository(AdminEntity::class);
        $Admin = $AdminRepository->findOneBy([
            'login' => $this->username,
            'deleteFlag' => 0
        ]);
        return $Admin;
    }

    public function getEntityManager()
    {
        return $this->getObjectManager()->get(EntityManagerInterface::class);
    }

    /**
     * CryptManagerからCryptオブジェクトを取得する
     *
     * @return PasswordInterface
     */
    public function getCrypt() : PasswordInterface
    {
        return $this->getCryptManager()->createPasswordCrypt(self::PASSWORD_TYPE);
    }
}
