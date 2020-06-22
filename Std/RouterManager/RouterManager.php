<?php
/**
 * PHP version 7
 * File RouterManager.php
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
 * Interface RouterManager
 *
 * @category Interface
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class RouterManager implements RouterManagerInterface
{
    private $routerPool = [];
    private $matched    = null;
    /**
     * register ルータを登録する
     *
     * @param string $namespace
     * @param RouterInterface $router
     * @return void
     */
    public function register(string $namespace, RouterInterface $router)
    {
        assert(
            !isset($this->routerPool[$namespace]),
            sprintf('すでに該当する名前空間「%s」のルータが登録されている。', $namespace)
        );
        $router->setRouterManager($this);
        $this->routerPool[$namespace] = $router;
    }

    /**
     * get 指定する名前空間のルータを取得する
     *
     * @param string $namespace
     * @return RouterInterface
     */
    public function get($namespace = null)
    {
        if ($namespace === null) {
            $namespace = __NAMESPACE__;
        }
        if (isset($this->routerPool[$namespace])) {
            return $this->routerPool[$namespace];
        }
    }

    /**
     * getMatched isMatchedのルータを取得する
     *
     * @return RouterInterface
     */
    public function getMatched() : RouterInterface
    {
        if ($this->matched === null) {
            $this->matched = $this->get(__NAMESPACE__);
            foreach ($this->getRouters() as $Router) {
                if ($Router->isMatched()) {
                    $this->matched = $Router;
                    break;
                }
            }
        }
        return $this->matched;
    }

    public function getRouters()
    {
        return $this->routerPool;
    }
}
