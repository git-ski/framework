<?php
/**
 * PHP version 7
 * File Project\History\Helper\OperationHelper.php
 *
 * @category Helper\Filter
 * @package  Project\History
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\History\Helper\Filter;

use Std\EntityManager\EntityInterface;
use Project\History\Helper\Filter\Common;
use Project\AdminUser\Entity\LoginAttemptW;
use Project\AdminUser\Admin\Authentication\Authentication as AdminAuthentication;
use Project\Customer\Entity\CustomerLoginAttemptW;
use Project\Customer\Front\Authentication\Authentication as CustomerAuthentication;

/**
 * Class Reservation
 *
 * @category Helper\Filter
 * @package  Project\History
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class Login extends Common
{
    const ADMIN     = 'admin';
    const CUSTOMER  = 'customer';

    public function filter($LoginAttempt)
    {
        $data = null;
        switch (true) {
            case $LoginAttempt instanceof LoginAttemptW:
                $Authentication = $this->getObjectManager()->get(AdminAuthentication::class);
                if ($Authentication->hasIdentity()) {
                    $data = [
                        self::ADMIN  => $Authentication->getIdentity(),
                    ];
                }
                break;
            case $LoginAttempt instanceof CustomerLoginAttemptW:
                $Authentication = $this->getObjectManager()->get(CustomerAuthentication::class);
                if ($Authentication->hasIdentity()) {
                    $data = [
                        self::CUSTOMER  => $Authentication->getIdentity(),
                    ];
                }
                break;
        }
        return $data;
    }
}
