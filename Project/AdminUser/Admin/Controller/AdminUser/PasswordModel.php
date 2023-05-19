<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\AdminUser\Admin\Controller\AdminUser;

use Std\EntityManager\EntityInterface;
use Project\AdminUser\Model\AdminModel;
use Project\AdminUser\Model\AdminLModel;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class PasswordModel extends AdminModel
{
    public function update($idOrAdmin, $data = null) : EntityInterface
    {

        $data['tempPasswordFlag']  = false;
        $Admin       = parent::get($idOrAdmin);
        if ($Admin instanceof EntityInterface) {
            $AdminLModel = $this->getObjectManager()->get(AdminLModel::class);
            // 履歴を残す
            $logData = $Admin->toArray() + [
                'Admin'   => $Admin,
                'logType' => AdminLModel::getPropertyValue('logType', 'ADMINL_LOGTYPE_PASSWORD')
            ];
            $AdminLModel->create($logData);
        }
        return parent::update($Admin, $data);
    }
}
