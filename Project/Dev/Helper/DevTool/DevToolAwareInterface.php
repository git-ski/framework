<?php
/**
 * PHP version 7
 * File Project\Dev\Helper\DevToolAwareInterface.php
 *
 * @category Controller
 * @package  Project\Dev\Helper\DevTool
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Dev\Helper\DevTool;

/**
 * Interface Project\Dev\Helper\DevToolAwareInterface
 *
 * @category Interface
 * @package  Project\Dev\Helper\DevTool
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
interface DevToolAwareInterface
{
    /**
     * Method index
     *
     * @param DevToolInterface $DevTool
     *
     * @return Object
     */
    public function setDevTool(DevToolInterface $DevTool);

    /**
     * Method index
     *
     * @return DevToolInterface $DevTool
     */
    public function getDevTool() : DevToolInterface;
}
