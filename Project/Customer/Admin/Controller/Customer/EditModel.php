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
class EditModel extends CustomerModel
{
    public function update($idOrCustomer, $data = null) : EntityInterface
    {

        if (isset($data['mailmagazineReceiveFlag'])) {
            $data['mailmagazineReceiveFlag'] = self::getPropertyValue('mailmagazineReceiveFlag', 'CUSTOMER_MAILMAGAZINE_RECEIVEFLAG_ON');
        } else {
            $data['mailmagazineReceiveFlag'] = self::getPropertyValue('mailmagazineReceiveFlag', 'CUSTOMER_MAILMAGAZINE_RECEIVEFLAG_OFF');
        }

        $Customer = parent::update($idOrCustomer, $data);
        // 履歴を残す
        $CustomerLModel = $this->getObjectManager()->get(CustomerLModel::class);
        $data = $Customer->toArray() + [
            'Customer'   => $Customer,
            'mPrefectureId' => !empty($Customer->getPrefecture()) ? $Customer->getPrefecture()->getPrefectureId() : null,
            'logType' => CustomerLModel::getPropertyValue('logType', 'CUSTOMERL_LOGTYPE_EDIT')
        ];
        $CustomerLModel->create($data);

        return $Customer;
    }
}
