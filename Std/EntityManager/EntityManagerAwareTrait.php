<?php
/**
 * PHP version 7
 * File EntityManagerAwareTrait.php
 *
 * @category Interface
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\EntityManager;

use Framework\ObjectManager\ObjectManager;

/**
 * Trait EntityManagerAwareTrait
 *
 * @category Trait
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait EntityManagerAwareTrait
{
    private static $EntityManager;

    /**
     * Method setEntityManager
     *
     * @param EntityManagerInterface $EntityManager EntityManager
     *
     * @return $this
     */
    public function setEntityManager(EntityManagerInterface $EntityManager)
    {
        self::$EntityManager = $EntityManager;
        return $this;
    }

    /**
     * Method getEntityManager
     *
     * @return EntityManagerInterface $EntityManager
     */
    public function getEntityManager() : EntityManagerInterface
    {
        if (null === self::$EntityManager) {
            self::$EntityManager = ObjectManager::getSingleton()->get(EntityManagerInterface::class);
        }
        return self::$EntityManager;
    }
}
