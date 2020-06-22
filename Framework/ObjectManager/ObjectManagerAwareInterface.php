<?php
/**
 * PHP version 7
 * File ObjectManagerAwareInterface.php
 *
 * @category Interface
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\ObjectManager;

/**
 * Interface ObjectManagerAwareInterface
 *
 * @category Interface
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ObjectManagerAwareInterface
{
    /**
     * Method setObjectMananger
     *
     * @param ObjectManagerInterface $objectManager ObjectManager
     *
     * @return void
     */
    public function setObjectManager(ObjectManagerInterface $objectManager);

    /**
     * Method getObjectManager
     *
     * @return ObjectManagerInterface $ObjectManager
     */
    public function getObjectManager() : ObjectManagerInterface;
}
