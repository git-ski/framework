<?php
/**
 * PHP version 7
 * File RbacAwareInterface.php
 *
 * @category Controller
 * @package  Std\AclManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\AclManager;

/**
 * Interface RbacAwareInterface
 *
 * @category Interface
 * @package  Std\AclManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface RbacAwareInterface
{
    /**
     * Method index
     *
     * @param RbacInterface $Rbac
     *
     * @return Object
     */
    public function setRbac(RbacInterface $Rbac);

    /**
     * Method index
     *
     * @return RbacInterface $Rbac
     */
    public function getRbac() : RbacInterface;
}
