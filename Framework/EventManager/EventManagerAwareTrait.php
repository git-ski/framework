<?php
/**
 * PHP version 7
 * File EventManagerAwareTrait.php
 *
 * @category Interface
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\EventManager;

/**
 * Trait EventManagerAwareTrait
 *
 * @category Trait
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait EventManagerAwareTrait
{
    private static $EventManager = null;

    /**
     * Method setEventManager
     *
     * @param EventManagerInterface $EventManager EventManager
     *
     * @return $this
     */
    public function setEventManager(EventManagerInterface $EventManager)
    {
        self::$EventManager = $EventManager;
        return $this;
    }

    /**
     * Method getEventManager
     *
     * @return EventManagerInterface $EventManager
     */
    public function getEventManager() : EventManagerInterface
    {
        return self::$EventManager;
    }
}
