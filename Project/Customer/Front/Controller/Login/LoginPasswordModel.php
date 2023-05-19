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

namespace Project\Customer\Front\Controller\Login;

use Std\EntityManager\EntityInterface;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Project\Customer\Model\CustomerModel;
use Project\Customer\Model\CustomerLoginAttemptWModel;
use Project\Customer\Entity\CustomerLoginAttemptW;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class LoginPasswordModel extends CustomerLoginAttemptWModel implements
    HttpMessageManagerAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;

    public function create($data) : EntityInterface
    {

        $HttpMessageManager = $this->getHttpMessageManager();
        $Request            = $HttpMessageManager->getRequest();
        $Server             = $Request->getServerParams();
        $data['ip']         = $Server['HTTP_X_FORWARDED_FOR'] ?? $Server['REMOTE_ADDR'];
        // ログイン成功時は、最終ログイン日時を対象AdminUserに保存する
        if (isset($data['customerId']) && $data['status'] === self::getPropertyValue('status', 'CUSTOMERLOGINATTEMPTW_STATUS_SUCCESS')) {
            $CustomerModel = $this->getObjectManager()->get(CustomerModel::class);
            $Date       = new \DateTime();
            $CustomerModel->update($data['customerId'], [
                'lastLogintDatetime' => $Date->format('Y-m-d H:i:s'),
            ]);
            // さらに、ログイン成功すると、それまでの失敗レコードを削除する※DeleteFlagを立つ
            // それまでの成功レコードを削除しない
            $this->deleteFailture($data);
        }
        return parent::create($data);
    }

    public function deleteFailture($data)
    {
        $QueryBuilder = $this->getEntityManager()->createQueryBuilder();
        $QueryBuilder->update(CustomerLoginAttemptW::class, 'law');
        $QueryBuilder->set('law.deleteFlag', '1');
        $QueryBuilder->where('law.login = :login');
        $QueryBuilder->andWhere('law.ip = :ip');
        $QueryBuilder->andWhere('law.status = :status');
        $QueryBuilder->setParameters([
            'login' => $data['login'],
            'ip'    => $data['ip'],
            'status'=> CustomerLoginAttemptWModel::getPropertyValue('status', 'CustomerLOGINATTEMPTW_STATUS_FAILTURE'),
        ]);
        $QueryBuilder->getQuery()->execute();
    }

    public function logout()
    {

    }
}
