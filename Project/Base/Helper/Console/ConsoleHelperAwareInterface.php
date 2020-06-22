<?php
/**
 * PHP version 7
 * File ConsoleHelperAwareInterface.php
 *
 * @category Module
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Helper\Console;

/**
 * Interface ConsoleHelperAwareInterface
 *
 * @category Helper
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ConsoleHelperAwareInterface
{
    /**
     * Method setConsoleHealper
     *
     * @param ConsoleHelperInterface $ConsoleHelper ConsoleHelper
     *
     * @return $this
     */
    public function setConsoleHelper(ConsoleHelperInterface $ConsoleHelper);

    /**
     * Method getConsoleHelper
     *
     * @return ConsoleHelperInterface
     */
    public function getConsoleHelper() : ConsoleHelperInterface;
}
