<?php
/**
 * PHP version 7
 * File DeleteController.php
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
use Project\Customer\Model\CustomerLModel;
use Project\Customer\Entity\Customer;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class WithdrawModel extends CustomerModel
{
    public function withdraw($idOrCustomer, $withdraw) : EntityInterface
    {

        $withdraw['memberWithdrawDate'] = $this->getDateTimeForEntity()->format('Y-m-d');
        $withdraw['withdrawReason'] = $this->getTranslator()->translate($withdraw['withdrawReason']);
        $Customer = parent::update($idOrCustomer, $withdraw);
        if ($Customer instanceof EntityInterface) {
            $CustomerLModel = $this->getObjectManager()->get(CustomerLModel::class);
            // 履歴を残す
            $logData = $Customer->toArray() + [
                'Customer'   => $Customer,
                'mPrefectureId' => !empty($Customer->getPrefecture()) ? $Customer->getPrefecture()->getPrefectureId() : null,
                'logType' => CustomerLModel::getPropertyValue('logType', 'CUSTOMERL_LOGTYPE_WITHDRAW')
            ];
            $CustomerLModel->create($logData);
        }
        return $Customer;
    }

    public static function getValueOptions() : array
    {
        return [
            'withdrawReason' => [
                'CUSTOMER_WITHDRAW_REASON_0' => 'CUSTOMER_WITHDRAW_REASON_0',
                'CUSTOMER_WITHDRAW_REASON_1' => 'CUSTOMER_WITHDRAW_REASON_1',
                'CUSTOMER_WITHDRAW_REASON_2' => 'CUSTOMER_WITHDRAW_REASON_2',
                'CUSTOMER_WITHDRAW_REASON_3' => 'CUSTOMER_WITHDRAW_REASON_3',
                'CUSTOMER_WITHDRAW_REASON_4' => 'CUSTOMER_WITHDRAW_REASON_4',
            ]
        ];
    }
}
