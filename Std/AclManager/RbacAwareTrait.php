<?php
/**
 * PHP version 7
 * File RbacAwareTrait.php
 *
 * @category Controller
 * @package  Std\AclManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\AclManager;

use Framework\ObjectManager\ObjectManager;

/**
 * Trait RbacAwareTrait
 *
 * @category Trait
 * @package  Std\AclManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait RbacAwareTrait
{
    private static $Rbac;

    /**
     * Method index
     *
     * @param RbacInterface $Rbac
     *
     * @return Object
     */
    public function setRbac(RbacInterface $Rbac)
    {
        self::$Rbac = $Rbac;
        return $this;
    }

    /**
     * Method index
     *
     * @return RbacInterface $Rbac
     */
    public function getRbac() : RbacInterface
    {
        return self::$Rbac;
    }
}
