<?php
/**
 * PHP version 7
 * File RouterAwareInterface.php
 *
 * @category Router
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\RouterManager;

/**
 * Interface RouterManagerAwareInterface
 *
 * @category Interface
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface RouterManagerAwareInterface
{
    /**
     * Method setRouterManager
     *
     * @param RouterManagerInterface $RouterManager RouterManager
     * @return mixed
     */
    public function setRouterManager(RouterManagerInterface $RouterManager);

    /**
     * Method getRouterManager
     *
     * @return RouterManagerInterface $RouterManager
     */
    public function getRouterManager() : RouterManagerInterface;
}
