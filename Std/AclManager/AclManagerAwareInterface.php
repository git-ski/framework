<?php
/**
 * PHP version 7
 * File Std\AclManagerAwareInterface.php
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
 * Interface Std\AclManagerAwareInterface
 *
 * @category Interface
 * @package  Std\AclManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface AclManagerAwareInterface
{
    /**
     * Method index
     *
     * @param AclManagerInterface $AclManager
     *
     * @return Object
     */
    public function setAclManager(AclManagerInterface $AclManager);

    /**
     * Method index
     *
     * @return AclManagerInterface $AclManager
     */
    public function getAclManager() : AclManagerInterface;
}
