<?php
/**
 * PHP version 7
 * File ObjectManagerAwareTrait.php
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
 * Trait ObjectManagerAwareTrait
 *
 * @category Trait
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait ObjectManagerAwareTrait
{
    private static $ObjectManager = null;

    /**
     * Method setObjectMananger
     *
     * @param ObjectManagerInterface $ObjectManager ObjectManager
     *
     * @return void
     */
    public function setObjectManager(ObjectManagerInterface $ObjectManager)
    {
        return self::$ObjectManager = $ObjectManager;
    }

    /**
     * Method getObjectManager
     *
     * @return ObjectManagerInterface $ObjectManager
     */
    public function getObjectManager() : ObjectManagerInterface
    {
        if (self::$ObjectManager === null) {
            $this->setObjectManager(ObjectManager::getSingleton());
        }
        return self::$ObjectManager;
    }
}
