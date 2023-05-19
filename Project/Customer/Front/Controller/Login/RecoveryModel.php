<?php
/**
 * PHP version 7
 * File RecoveryModel.php
 *
 * @category Model
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\Controller\Login;

use Std\EntityManager\EntityInterface;
use Project\Customer\Model\CustomerReminderModel;
use Project\Customer\Model\CustomerModel;
use Project\Customer\Front\Message\Login\RecoveryMessage;
use DateTime;

/**
 * Class RecoveryModel
 *
 * @category Model
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RecoveryModel extends CustomerReminderModel
{
    public function recovery($input) : EntityInterface
    {

        $customerReminder = $input['customerReminder'];
        $customer         = $input['customer'];
        $CustomerModel    = $this->getObjectManager()->get(CustomerModel::class);
        $customerReminder['useFlag'] = 1;
        $Customer         = $CustomerModel->update($customer['customerId'], $customer);
        // 処理に応じて、create/update/deleteに変更する。
        return parent::update($customerReminder['customerReminderId'], $customerReminder);
    }

    public function getOneByHashKey($urlHashKey, $reminderExpiration)
    {
        $expiration = new DateTime();
        $expiration->modify('- ' . $reminderExpiration . ' minutes');
        $CustomerReminder = parent::getOneBy([
            'urlHashKey' => $urlHashKey,
            'useFlag'    => 0
        ], [
            'customerReminderId' => 'Desc'
        ]);
        if ($CustomerReminder) {
            $created = $CustomerReminder->getCreateDate() . ' ' . $CustomerReminder->getCreateTime();
            $CreateDateTime = new DateTime($created);
            if ($CreateDateTime > $expiration) {
                return $CustomerReminder;
            }
        }
        return null;
    }
}
