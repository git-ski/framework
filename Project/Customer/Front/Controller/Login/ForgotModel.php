<?php
/**
 * PHP version 7
 * File ForgotModel.php
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
use Std\RouterManager\RouterManagerAwareInterface;
use Project\Customer\Model\CustomerReminderModel;
use Project\Customer\Model\CustomerModel;
use Project\Customer\Front\Message\Login\ForgotMessage;
use Project\Customer\Front\Controller\Login\RecoveryController;

/**
 * Class ForgotModel
 *
 * @category Model
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ForgotModel extends CustomerReminderModel implements
    CryptManagerAwareInterface,
    RouterManagerAwareInterface
{
    use \Std\CryptManager\CryptManagerAwareTrait;
    use \Std\RouterManager\RouterManagerAwareTrait;

    public function forgot($input, $reminderExpiration) : EntityInterface
    {

        $Customer       = $this->getCustomerBy($input);
        $RandomString   = $this->getCryptManager()->getRandomString();
        $reminder = [
            'urlHashKey'    => $RandomString->generate(16),
            'verifyHashKey' => $RandomString->generate(8),
            'Customer'      => $Customer,
        ];
        $CustomerReminder   = parent::create($reminder);
        $recoveryLink       = $this->getRouter()->linkto(RecoveryController::class, null, [
            'h' => $CustomerReminder->getUrlHashKey()
        ]);
        $ForgotMessage      = $this->getObjectManager()->create(ForgotMessage::class);
        $ForgotMessage->setData([
            'Customer'      => $Customer,
            'Reminder'      => $CustomerReminder,
            'recoveryLink'  => $recoveryLink,
            'reminderExpiration' => $reminderExpiration
        ]);
        $ForgotMessage->send();

        return $CustomerReminder;
    }

    public function getCustomerBy($input)
    {
        $criteria = [
            'login' => $input['login'],
            'email' => $input['email'],
        ];
        return $this->getObjectManager()->get(CustomerModel::class)->getCustomerBy($criteria);
    }
}
