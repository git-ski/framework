<?php
/**
 * PHP version 7
 * File EntityManagerAwareInterface.php
 *
 * @category Interface
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\EntityManager;

/**
 * Interface EntityManagerAwareInterface
 *
 * @category Interface
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface EntityManagerAwareInterface
{
    /**
     * Method setEntityManager
     *
     * @param EntityManagerInterface $EntityManager EntityManager
     *
     * @return mixed
     */
    public function setEntityManager(EntityManagerInterface $EntityManager);

    /**
     * Method getEntityManager
     *
     * @return EntityManagerInterface $EntityManager
     */
    public function getEntityManager() : EntityManagerInterface;
}
