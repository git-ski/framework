<?php
/**
 * PHP version 7
 * File EditModel.php
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
use Project\Customer\Front\Controller\Customer\RegisterModel as CustomerRegisterModel;
use Project\Customer\Model\CustomerLModel;

/**
 * Class EditModel
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class EditModel extends CustomerRegisterModel
{
    public function update($idOrCustomer, $data = null) : EntityInterface
    {

        $this->processDataUpdate($data);
        $Customer = parent::update($idOrCustomer, $data);
        if ($Customer instanceof EntityInterface) {
            $CustomerLModel = $this->getObjectManager()->get(CustomerLModel::class);
            // 履歴を残す
            $logData = $Customer->toArray() + [
                'Customer'   => $Customer,
                'mPrefectureId' => !empty($Customer->getPrefecture()) ? $Customer->getPrefecture()->getPrefectureId() : null,
                'logType' => CustomerLModel::getPropertyValue('logType', 'CUSTOMERL_LOGTYPE_EDIT')
            ];
            $CustomerLModel->create($logData);
        }
        return $Customer;
    }

    protected function processDataUpdate(&$data)
    {
        $birthDate = $this->getBirthDate($data);
        if (!empty($birthDate)) {
            $data['birthDate'] = $birthDate;
        }
        if (isset($data['mailmagazineReceiveFlag'])) {
            $data['mailmagazineReceiveFlag'] = self::getPropertyValue('mailmagazineReceiveFlag', 'CUSTOMER_MAILMAGAZINE_RECEIVEFLAG_ON');
        }else{
            $data['mailmagazineReceiveFlag'] = self::getPropertyValue('mailmagazineReceiveFlag', 'CUSTOMER_MAILMAGAZINE_RECEIVEFLAG_OFF');
        }
    }
}
