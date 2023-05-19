<?php
/**
 * PHP version 7
 * File Project\History\Helper\OperationHelper.php
 *
 * @category HistoryService
 * @package  Project\History
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\History\Helper;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Project\History\Model\AdminOperationLModel;
use Project\History\Model\CustomerOperationLModel;
use Project\History\Model\ReservationLModel;
use Project\History\Helper\Filter\Common;
use Project\History\Helper\Filter\Reservation;
use Project\History\Helper\Filter\Login;

/**
 * Class HistoryService
 *
 * @category HistoryService
 * @package  Project\History
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class OperationHelper implements
    ObjectManagerAwareInterface,
    HttpMessageManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;

    public function logAuthOperation($action, $data)
    {
        $LoginFilter = $this->getObjectManager()->get(Login::class);
        $filtered = $LoginFilter->filter($data);
        if (empty($filtered)) {
            return ;
        }
        $adminIdentity    = $filtered[Login::ADMIN] ?? null;
        $customerIdentity = $filtered[Login::CUSTOMER] ?? null;
        $this->logAdminOperation($action, $data, $adminIdentity);
        $this->logCustomerOperation($action, $data, $customerIdentity);
    }

    public function logAdminOperation($action, $data, $admin = null)
    {
        if (empty($admin)) {
            return null;
        }
        $CommonFilter = $this->getObjectManager()->get(Common::class);
        $data = $CommonFilter->filter($data);
        $Uri  = $this->getHttpMessageManager()->getRequest()->getUri();
        $AdminOperationLModel = $this->getObjectManager()->get(AdminOperationLModel::class);
        $AdminOperationLModel->create([
            'mAdminId'  => $admin['adminId'],
            'url'       => (string) $Uri,
            'action'    => $action,
            'data'      => json_encode($data)
        ]);
    }

    public function logCustomerOperation($action, $data, $customer = null)
    {
        if (empty($customer)) {
            return null;
        }
        $CommonFilter = $this->getObjectManager()->get(Common::class);
        $data = $CommonFilter->filter($data);
        $Uri  = $this->getHttpMessageManager()->getRequest()->getUri();
        $CustomerOperationLModel = $this->getObjectManager()->get(CustomerOperationLModel::class);
        $CustomerOperationLModel->create([
            'mCustomerId'   => $customer['customerId'],
            'url'           => (string) $Uri,
            'action'        => $action,
            'data'          => json_encode($data)
        ]);
    }
}
