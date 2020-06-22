<?php
/**
 * PHP version 7
 * File Std\LoggerManagerAwareInterface.php
 *
 * @category Controller
 * @package  Std\LoggerManager
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\LoggerManager;

/**
 * Interface Std\LoggerManagerAwareInterface
 *
 * @category Interface
 * @package  Std\LoggerManager
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface LoggerManagerAwareInterface
{
    /**
     * Method index
     *
     * @param LoggerManagerInterface $LoggerManager
     *
     * @return Object
     */
    public function setLoggerManager(LoggerManagerInterface $LoggerManager);

    /**
     * Method index
     *
     * @return LoggerManagerInterface $LoggerManager
     */
    public function getLoggerManager() : LoggerManagerInterface;
}
