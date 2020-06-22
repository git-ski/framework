<?php
/**
 * PHP version 7
 * File RouterInterface.php
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
 * Interface RouterInterface
 *
 * @category Interface
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface RouterInterface
{
    const TRIGGER_ROUTERLIST_LOADED = 'router.list.loaded';
    const TRIGGER_ROUTEMISS = 'route.miss';

    /**
     * Method isMatched
     *
     * @return boolean
     */
    public function isMatched() : bool;

    /**
     * Method dispatch
     *
     * @return mixed
     */
    public function dispatch();

    /**
     * Method getRouterList
     *
     * @return array RouterList
     */
    public function getRouterList();

    /**
     * Method isFaviconRequest
     *
     * @return boolean
     */
    public function isFaviconRequest() : bool;

    public function setRouterManager($routerManager);
}
