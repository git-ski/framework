<?php
/**
 * PHP version 7
 * File RouterManagerInterface.php
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
 * Interface RouterManagerInterface
 *
 * @category Interface
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface RouterManagerInterface
{
    /**
     * register ルータを登録する
     *
     * @param string $namespace
     * @param RouterInterface $router
     * @return void
     */
    public function register(string $namespace, RouterInterface $router);

    /**
     * get 指定名前空間のルータを取得する
     *
     * @param string $namespace
     * @return RouterInterface
     */
    public function get($namespace);

    /**
     * getMatched isMatchedのルータを取得する
     *
     * @return RouterInterface
     */
    public function getMatched() : RouterInterface;
}
