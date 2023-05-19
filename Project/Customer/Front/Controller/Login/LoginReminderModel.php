<?php
/**
 * PHP version 7
 * File LoginReminderModel.php
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
use Std\CryptManager\CryptManagerAwareInterface;
use Project\Customer\Model\CustomerModel;
use Project\Customer\Front\Message\Login\LoginReminderMessage;

/**
 * Class LoginReminderModel
 *
 * @category Model
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class LoginReminderModel extends CustomerModel
{
    use \Std\CryptManager\CryptManagerAwareTrait;

    public function loginReminder($criteria) : EntityInterface
    {
        // 論理削除済みのレコードは取得しない
        $criteria = array_merge($criteria, [
            'deleteFlag' => 0,
            'memberWithdrawDate' => NULL
        ]);

        $Customers            = $this->getList($criteria);
        $LoginReminderMessage = $this->getObjectManager()->create(LoginReminderMessage::class);
        $LoginReminderMessage->setData([
            'Customers' => $Customers
        ]);
        $LoginReminderMessage->send();
        return $Customers[0];
    }
}
