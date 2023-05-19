<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\CustomerUser\Customer
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\Controller\Customer;

use Std\EntityManager\EntityInterface;
use Project\Customer\Model\CustomerModel;
use Project\Customer\Model\CustomerLModel;
use Project\Customer\Model\CustomerLoginAttemptWModel;
use Std\SessionManager\SessionManagerAwareInterface;
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\CustomerUser\Customer
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class PasswordModel extends CustomerModel implements
    SessionManagerAwareInterface,
    AuthenticationAwareInterface
{
    use \Std\SessionManager\SessionManagerAwareTrait;
    use \Std\Authentication\AuthenticationAwareTrait;

    public function update($idOrCustomer, $data = null) : EntityInterface
    {

        $data['tempPasswordFlag'] = parent::getPropertyValue('tempPasswordFlag','CUSTOMER_TEMPPASSWORDFLAG_OFF');
        $Customer       = parent::get($idOrCustomer);
        if ($Customer instanceof EntityInterface) {
            $CustomerLModel = $this->getObjectManager()->get(CustomerLModel::class);
            // 履歴を残す
            $logData = $Customer->toArray() + [
                'Customer'   => $Customer,
                'mPrefectureId' => $Customer->getPrefecture() != null ? $Customer->getPrefecture()->getPrefectureId() : null,
                'logType' => CustomerLModel::getPropertyValue('logType', 'CUSTOMERL_LOGTYPE_PASSWORD')
            ];
            $CustomerLModel->create($logData);
        }

        return parent::update($Customer, $data);
    }

    public function forceLogout($Customer)
    {
        $CustomerLoginAttemptWModel = $this->getObjectManager()->get(CustomerLoginAttemptWModel::class);
        $CustomerLoginAttempts      = $CustomerLoginAttemptWModel->getRepository()->findBy([
            'login'         => $Customer->getEmail(),
            'status'        => CustomerLoginAttemptWModel::getPropertyValue('status', 'CUSTOMERLOGINATTEMPTW_STATUS_SUCCESS'),
            'deleteFlag'    => 0,
        ]);
        $SessionManager = $this->getSessionManager()->getSessionManager();
        $nowSessionId   = $SessionManager->getId();
        $loginAttemptWStatusExpirated = CustomerLoginAttemptWModel::getPropertyValue('status', 'CUSTOMERLOGINATTEMPTW_STATUS_EXPIRATED');
        foreach ($CustomerLoginAttempts as $CustomerLoginAttempt) {
            // ログイン成功レコードにsession_idを取得してログアウトする。
            $sessionId = $CustomerLoginAttempt->getSessionId();
            session_abort();
            session_id($sessionId);
            session_start();
            $SessionManager->destroy();
            if ($this->getAuthentication()->hasIdentity()) {
                $this->getAuthentication()->clearIdentity();
            }
            $CustomerLoginAttempt->setStatus($loginAttemptWStatusExpirated);
            $this->getEntityManager()->merge($CustomerLoginAttempt);
        }
        session_abort();
        session_id($nowSessionId);
        session_start();
        $SessionManager->destroy();
        return $this->getEntityManager()->flush();
    }
}
