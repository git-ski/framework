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
use Project\Customer\Model\CustomerLModel;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class DeleteModel extends CustomerModel
{
    public function delete($idOrCustomer) : EntityInterface
    {

        $Customer = parent::delete($idOrCustomer);

        if ($Customer instanceof EntityInterface) {
            $CustomerLModel = $this->getObjectManager()->get(CustomerLModel::class);
            // 履歴を残す
            $logData = $Customer->toArray() + [
                'Customer'   => $Customer,
                'mPrefectureId' => !empty($Customer->getPrefecture()) ? $Customer->getPrefecture()->getPrefectureId() : null,
                'logType' => CustomerLModel::getPropertyValue('logType', 'CUSTOMERL_LOGTYPE_DELETE')
            ];
            $CustomerLModel->create($logData);
        }
        return $Customer;
    }
}
