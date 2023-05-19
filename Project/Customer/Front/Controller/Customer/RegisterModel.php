<?php
/**
 * PHP version 7
 * File RegisterModel.php
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\Controller\Customer;

use Std\EntityManager\EntityInterface;
use Project\Customer\Model\CustomerModel;
use Project\Customer\Model\CustomerTemporaryLModel;
use Project\Customer\Front\Message\Customer\RegisterMessage as CustomerRegisterMessage;
use Project\Language\LocaleDetector\Front as LocaleDetectorFront;
use Project\Base\Model\CountryModel;
use DateTime;

/**
 * Class RegisterModel
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RegisterModel extends CustomerModel
{
    public function create($data) : EntityInterface
    {

        $updateTemporary = [
            'useFlag' => CustomerTemporaryLModel::getPropertyValue('useFlag', 'CUSTOMERTEMPORARYL_USEFLAG_ON')
        ];
        $CustomerTemporaryLModel = $this->getObjectManager()->get(CustomerTemporaryLModel::class);
        $CustomerTemporaryLModel->update($data['customerTemporaryLId'], $updateTemporary);
        $this->processDataCreate($data);
        $Customer = parent::create($data);
        // ここでメール送信処理を追加
        $RegisterMessage    = $this->getObjectManager()->create(CustomerRegisterMessage::class);
        $RegisterMessage->setData([
            'Customer' => $Customer
        ]);
        $RegisterMessage->send();
        return $Customer;
    }

    public function checkCustomerExist($criteria, $customerId = null): bool
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
        $qb->setParameters($parameters);
        $result = $qb->getQuery()->getOneOrNullResult();
        if (!empty($result)) {
            return true;
        }
        return false;
    }

    protected function processDataCreate(&$data)
    {
        $data['tempPasswordFlag'] = self::getPropertyValue('tempPasswordFlag', 'CUSTOMER_TEMPPASSWORDFLAG_OFF');
        if (isset($data['mailmagazineReceiveFlag'])) {
            $data['mailmagazineReceiveFlag'] = self::getPropertyValue('mailmagazineReceiveFlag', 'CUSTOMER_MAILMAGAZINE_RECEIVEFLAG_ON');
        }
        $data['memberRegisterDate'] = $this->getDateTimeForEntity()->format('Y-m-d');
        $birthDate = $this->getBirthDate($data);
        if ($birthDate) {
            $data['birthDate'] = $birthDate;
        }
        $data['defaultLanguage'] = self::getPropertyValue('defaultLanguage', 'CUSTOMER_DEFAULTLANGUAGE_JA');
    }

    protected function getBirthDate($data): string
    {
        $result = null;
        $date = DateTime::createFromFormat('Y-m-d H:i:s', sprintf('%s-%s-%s 00:00:00', $data['birthDateYear'], $data['birthDateMonth'], $data['birthDateDay']));
        if ($date) {
            $result = $date->format('Y-m-d');
        }
        return $result;
    }
}
