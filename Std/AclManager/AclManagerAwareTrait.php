<?php
/**
 * PHP version 7
 * File AclManagerAwareTrait.php
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
 * Trait AclManagerAwareTrait
 *
 * @category Trait
 * @package  Std\AclManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait AclManagerAwareTrait
{
    private static $AclManager;

    /**
     * Method index
     *
     * @param AclManagerInterface $AclManager
     *
     * @return Object
     */
    public function setAclManager(AclManagerInterface $AclManager)
    {
        self::$AclManager = $AclManager;
        return $this;
    }

    /**
     * Method index
     *
     * @return AclManagerInterface $AclManager
     */
    public function getAclManager() : AclManagerInterface
    {
        return self::$AclManager;
    }
}
