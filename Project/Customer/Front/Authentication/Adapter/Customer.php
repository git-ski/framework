<?php
declare(strict_types=1);

namespace Project\Customer\Front\Authentication\Adapter;

use Std\Authentication\Adapter\AbstractAdapter;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\EntityManager\EntityManagerInterface;
use Project\Customer\Entity\Customer as CustomerEntity;
use Laminas\Authentication\Result;

class Customer extends AbstractAdapter implements ObjectManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;

    public function authenticate()
    {
        $Customer = $this->getCustomer();
        if ($Customer && $this->getCrypt()->verify($this->password, $Customer->getCustomerPassword())) {
            return new Result(Result::SUCCESS, $Customer->toArray(), ['Authenticated successfully.']);
        } else {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ['Invalid credentials.']);
        }
    }

    public function getCustomer()
    {
        $CustomerRepository = $this->getEntityManager()->getRepository(CustomerEntity::class);
        $Customer = $CustomerRepository->findOneBy([
            'login'                 => $this->username,
            'deleteFlag'            => 0,
            'memberWithdrawDate'    => null,
        ]);
        return $Customer;
    }

    public function getEntityManager()
    {
        return $this->getObjectManager()->get(EntityManagerInterface::class);
    }
}
