<?php
/**
 * PHP version 7
 * File AbstractRouter.php
 *
 * @category Interface
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\RouterManager;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\ObjectManager\SingletonInterface;
use Std\CacheManager\CacheManagerAwareInterface;
use Framework\EventManager\EventTargetInterface;

/**
 * Class AbstractRouter
 *
 * @category Class
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
abstract class AbstractRouter implements
    RouterInterface,
    ObjectManagerAwareInterface,
    EventTargetInterface,
    SingletonInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Framework\EventManager\EventTargetTrait;
    use \Framework\ObjectManager\SingletonTrait;

    const INDEX                  = 'index';

    private $request         = null;
    private $routerList      = null;
    protected $requestParam = null;
    private $routerManager   = null;
    private $routerPattern   = [];

    /**
     * Abstract Method loadRouter
     *
     * @return void
     */
    abstract public function loadRouter();

    /**
     * Method dispatch
     *
     * @return array $request
     */
    public function dispatch()
    {
        if ($this->request === null) {
            if (empty($this->request)) {
                $this->request = $this->parseRequest();
            }
            $req = $this->request['req'];
            $routerList = $this->getRouterList();
            $this->request['controller'] = $routerList[$req] ?? null;
            if (!$this->request['controller']) {
                $this->expandRouterPattern();
                $routerList = $this->getRouterList();
                $this->request['controller'] = $routerList[$req] ?? null;
            }
            if (!$this->request['controller']) {
                $this->triggerEvent(static::TRIGGER_ROUTEMISS);
            }
        }
        return $this->request;
    }

    public function registerRouterPattern(string $search, $replace, $default = null)
    {
        $this->routerPattern[] = [
            'search' => $search, 'replace' => $replace, 'default' => $default
        ];
    }

    protected function expandRouterPattern()
    {
        if (!empty($this->routerPattern)) {
            foreach ($this->routerPattern as [
                'search' => $search, 'replace' => $replace, 'default' => $default
            ]) {
                $this->replaceRouter($search, $replace, $default);
            }
            $this->routerPattern = [];
        }
        $routerList = $this->getRouterList() ?? [];
        foreach ($routerList as $uri => $controller) {
            unset($routerList[$uri]);
            $uri = preg_replace('/\[.+?\]/', '', $uri);
            $routerList[$uri] = $controller;
        }
        $this->setRouterList($routerList);
    }

    private function replaceRouter(string $search, $replace, $default = null)
    {
        $replaces = (array) $replace;
        $routerList = $this->getRouterList();
        foreach ($routerList as $uri => $controller) {
            if (strpos($uri, $search) !== false) {
                unset($routerList[$uri]);
                foreach ($replaces as $replace) {
                    $newUri = str_replace($search, $replace, $uri);
                    $routerList[$newUri] = $controller;
                }
                if (null !== $default) {
                    $defaultUri = str_replace($search, $default, $uri);
                    $routerList[$defaultUri] = $controller;
                }
            }
        }
        $this->setRouterList($routerList);
    }

    /**
     * リクエストをセットする
     *
     * @param array $request requestData
     *
     * @return $this
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * リクエストを取得する
     *
     * @return array $request requestData
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * リクエストパラメータをセットする
     *
     * @param array $param requestParam
     *
     * @return $this
     */
    public function setParam($param)
    {
        $this->requestParam = $param;
        return $this;
    }
    /**
     * Abstract Method parseRequest
     *
     * @return mixed
     */
    abstract public function parseRequest();

    /**
     * Method getIndex
     *
     * @return string $index
     */
    public function getIndex()
    {
        return self::INDEX;
    }

    /**
     * Method register
     *
     * @param array $route routeInfo
     *
     * @return $this
     */
    public function register($route)
    {
        foreach ($route as $req => $controller) {
            $this->routerList[$req] = $controller;
        }
        return $this;
    }

    /**
     * ルーターリストを取得する
     *
     * @return array $routerList
     */
    public function getRouterList()
    {
        if (!$this->routerList) {
            $defaultRouterManger = $this->getObjectManager()->get(RouterManagerInterface::class);
            $this->getObjectManager()->set(RouterManagerInterface::class, $this->getRouterManager());
            $this->loadRouter();
            $this->getObjectManager()->set(RouterManagerInterface::class, $defaultRouterManger);
            $this->triggerEvent(static::TRIGGER_ROUTERLIST_LOADED);
        }
        return $this->routerList;
    }

    /**
     * ルーターをセットする
     *
     * @param array $routerList routerList
     *
     * @return $this
     */
    public function setRouterList($routerList)
    {
        $this->routerList = $routerList;
        return $this;
    }

    /**
     * リクエスト内の'action'を取得する
     *
     * @return string $action
     */
    public function getAction()
    {
        $request = $this->getRequest();
        return $request["action"];
    }

    /**
     * リクエスト内の'controller'を取得する
     *
     * @return string $controller
     */
    public function getController()
    {
        $request = $this->getRequest();
        return $request['controller'];
    }

    public function setRouterManager($routerManager)
    {
        $this->routerManager = $routerManager;
    }

    public function getRouterManager()
    {
        if (null === $this->routerManager) {
            $routerManager = $this->getObjectManager()->create(RouterManager::class);
            $routerManager->register(__NAMESPACE__, $this);
        }
        return $this->routerManager;
    }

    /**
     * Method isMatched
     *
     * @return boolean
     */
    abstract public function isMatched() : bool;
}
