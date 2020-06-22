<?php
/**
 * PHP version 7
 * File ConsoleHelperAwareTrait.php
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
 * Trait ConsoleHelperAwareTrait
 *
 * @category Helper
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait ConsoleHelperAwareTrait
{
    private $ConsoleHelper;

    /**
     * Method setConsoleHealper
     *
     * @param ConsoleHelperInterface $ConsoleHelper ConsoleHelper
     *
     * @return $this
     */
    public function setConsoleHelper(ConsoleHelperInterface $ConsoleHelper)
    {
        $this->ConsoleHelper = $ConsoleHelper;
    }

    /**
     * Method getConsoleHelper
     *
     * @return ConsoleHelperInterface
     */
    public function getConsoleHelper() : ConsoleHelperInterface
    {
        return $this->ConsoleHelper;
    }
}
