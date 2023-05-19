<?php
/**
 * PHP version 7
 * File DevToolAwareTrait.php
 *
 * @category Controller
 * @package  Project\Dev\Helper\DevTool
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Dev\Helper\DevTool;

use Framework\ObjectManager\ObjectManager;

/**
 * Trait DevToolAwareTrait
 *
 * @category Trait
 * @package  Project\Dev\Helper\DevTool
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
trait DevToolAwareTrait
{
    private static $DevTool;

    /**
     * Method index
     *
     * @param DevToolInterface $DevTool
     *
     * @return Object
     */
    public function setDevTool(DevToolInterface $DevTool)
    {
        self::$DevTool = $DevTool;
        return $this;
    }

    /**
     * Method index
     *
     * @return DevToolInterface $DevTool
     */
    public function getDevTool() : DevToolInterface
    {
        return self::$DevTool;
    }
}
