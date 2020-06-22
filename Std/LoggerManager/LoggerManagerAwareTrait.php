<?php
/**
 * PHP version 7
 * File LoggerManagerAwareTrait.php
 *
 * @category Controller
 * @package  Std\LoggerManager
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\LoggerManager;

use Framework\ObjectManager\ObjectManager;

/**
 * Trait LoggerManagerAwareTrait
 *
 * @category Trait
 * @package  Std\LoggerManager
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait LoggerManagerAwareTrait
{
    private static $LoggerManager;

    /**
     * Method index
     *
     * @param LoggerManagerInterface $LoggerManager
     *
     * @return Object
     */
    public function setLoggerManager(LoggerManagerInterface $LoggerManager)
    {
        self::$LoggerManager = $LoggerManager;
        return $this;
    }

    /**
     * Method index
     *
     * @return LoggerManagerInterface $LoggerManager
     */
    public function getLoggerManager() : LoggerManagerInterface
    {
        return self::$LoggerManager;
    }
}
