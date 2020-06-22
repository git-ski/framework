<?php
/**
 * PHP version 7
 * File Router.php
 *
 * @category Router
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\RouterManager\Console;

use Std\RouterManager\AbstractRouter;
use Framework\ObjectManager\ModuleManager;

/**
 * Class Router
 *
 * @category Class
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Router extends AbstractRouter
{
    /**
     * Method loadRouter
     *
     * @return void
     */
    public function loadRouter()
    {
        foreach (glob(ROOT_DIR . 'Project/*/*/Command.php') as $routeInjection) {
            include $routeInjection;
        }
        foreach (ModuleManager::getRegisteredModules() as $module) {
            foreach (glob($module . '/*/Command.php') as $routeInjection) {
                include $routeInjection;
            }
        }
    }

    /**
     * Method getParam
     *
     * @return array $argv
     */
    private function getParam()
    {
        if ($this->requestParam === null) {
            $argv = $_SERVER['argv'];
            array_shift($argv);
            $this->setParam($argv);
        }
        return $this->requestParam;
    }

    /**
     * Method parseRequest
     *
     * @return array $request
     */
    public function parseRequest()
    {
        //[action, param]
        $request = [
            'req'        => null,
            'controller' => null,
            'action'     => self::INDEX,
            'param'      => []
        ];
        $tmp = $this->getParam();
        foreach ($tmp as $index => $arg) {
            if (strpos($arg, "=")) {
                $argTmp = explode("=", $arg);
                $name   = array_shift($argTmp);
                $val    = join("=", $argTmp);
                $request['param'][$name] = $val;
                unset($tmp[$index]);
            }
        }
        $request['req'] = array_shift($tmp);
        // php bin/console.php help cngo::module::create
        // 上記のようなコマンドも実行できるように、フラットのパラメータも渡していく。
        if (!empty($tmp)) {
            $request['param'] = array_merge($request['param'], $tmp);
        }
        $request['param'] = [$request['param']];
        return $request;
    }

    /**
     * Method redirect
     *
     * @param string      $controller ControllerClass
     * @param string|null $action     Action
     * @param mixed       $param      Param
     *
     * @return void
     */
    public function redirect($controller, $action = null, $param = null)
    {
        throw new \LogicException("can not redirct in console mode");
    }

    /**
     * Method linkto
     *
     * パラメータの変換は下記になる。
     * [
     *     'name' => 'test',
     *     'age'  => 30,
     * ]
     * =>
     * name=test age=30
     *
     * @param string $controller ControllerClass
     * @param mixed  $param      Param
     *
     * @return string command
     */
    public function findCommand($controller, $param = null)
    {
        $routerList = $this->getRouterList();
        $command = array_search($controller, $routerList);
        if ($command) {
            $param = (array) $param;
            if (!empty($param)) {
                $command .= ' ' . http_build_query($param, '', ' ');
            }
            return $command;
        } else {
            return null;
        }
    }

    /**
     * Method isMatched
     *
     * @return boolean
     */
    public function isMatched() : bool
    {
        // @codeCoverageIgnoreStart
        return true;
        // @codeCoverageIgnoreEndl
    }

    /**
     * Method isFaviconRequest
     *
     * @return boolean
     */
    public function isFaviconRequest() : bool
    {
        // @codeCoverageIgnoreStart
        return false;
        // @codeCoverageIgnoreEnd
    }
}
