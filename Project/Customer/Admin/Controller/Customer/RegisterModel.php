<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Admin\Controller\Customer;

use Std\EntityManager\EntityInterface;
use Project\Customer\Model\CustomerModel;
use Project\Customer\Admin\Message\Customer\RegisterMessage as CustomerRegisterMessage;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RegisterModel extends CustomerModel
{
    public function create($data) : EntityInterface
    {

        if (empty($data['customerPassword'])) {
            $RandomString = $this->getCryptManager()->getRandomString();
            $data['customerPassword'] = $RandomString->generate(8);
            $data['tempPasswordFlag'] = 1;
        }
        if (empty($data['memberRegisterDate'])) {
            $data['memberRegisterDate'] = $this->getDateTimeForEntity()->format('Y-m-d');
        }

        if (isset($data['mailmagazineReceiveFlag'])) {
            $data['mailmagazineReceiveFlag'] = self::getPropertyValue('mailmagazineReceiveFlag', 'CUSTOMER_MAILMAGAZINE_RECEIVEFLAG_ON');
        }

        $Customer = parent::create($data);
        if (isset($data['sendMailToCustomer'])) {
            // ここでメール送信処理を追加
            $RegisterMessage    = $this->getObjectManager()->create(CustomerRegisterMessage::class);
            $RegisterMessage->setData([
                'customer' => $data,
                'Customer' => $Customer,
            ]);
            $RegisterMessage->send();
        }

        return $Customer;
    }

    public function checkCustomerExist($criteria, $customerId = null, $customerNo = null): bool
    {
        $qb = $this->getRepository()->createQueryBuilder('mc');
        $qb->where('mc.deleteFlag = :mcDeleteFlag');
        $where = [];
        $parameters = [
            ':mcDeleteFlag' => self::getPropertyValue('deleteFlag', 'CUSTOMER_DELETEFLAG_OFF'),
        ];
        $qb->andWhere($qb->expr()->isNull('mc.memberWithdrawDate'));
        foreach ($criteria as $key => $val) {
            $where[] = $qb->expr()->eq('mc.' . $key, ':' . $key);
            $parameters[':' . $key] = $val;
        }
        $qb->andWhere($qb->expr()->orX()->addMultiple($where));
        if (!empty($customerId)) {
            $qb->andWhere($qb->expr()->neq('mc.customerId', ':customerId'));
            $parameters[':customerId'] = $customerId;
        }
        if (!empty($customerNo)) {
            $qb->andWhere($qb->expr()->neq('mc.customerNo', ':customerNo'));
            $parameters[':customerNo'] = $customerNo;
        }
        $qb->setParameters($parameters);
        $result = $qb->getQuery()->getOneOrNullResult();
        if (!empty($result)) {
            return true;
        }
        return false;
    }
}
