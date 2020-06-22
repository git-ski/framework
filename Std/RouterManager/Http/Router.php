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

namespace Std\RouterManager\Http;

use Framework\Application\HttpApplication;
use Framework\ObjectManager\ModuleManager;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Std\RouterManager\AbstractRouter;
use Laminas\Diactoros\Response\RedirectResponse;
use Std\SessionManager\SessionManagerAwareInterface;

/**
 * Interface Router
 *
 * @category Interface
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Router extends AbstractRouter implements
    HttpMessageManagerAwareInterface,
    SessionManagerAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
    use \Std\SessionManager\SessionManagerAwareTrait;

    const REDIRECT_HISTORY = 'redirect_history';

    private $request_uri    = null;
    //
    protected $target_domain = null;

    /**
     * Method loadRouter
     *
     * @return void
     */
    public function loadRouter()
    {
        foreach (glob(ROOT_DIR . 'Project/*/*/Route.php') as $routeInjection) {
            include $routeInjection;
        }
        foreach (ModuleManager::getRegisteredModules() as $module) {
            foreach (glob($module . '/*/Route.php') as $routeInjection) {
                include $routeInjection;
            }
        }
    }

    /**
     * Method linkto
     *
     * @param string $controller ControllerClass
     * @param mixed  $param      Param
     * @param array  $query      Query
     *
     * @return string url
     */
    public function linkto($controller, $param = null, $query = [])
    {
        $this->expandRouterPattern();
        $routerList = $this->getRouterList();
        $uri = array_search($controller, $routerList);
        if ($uri) {
            $uri = preg_replace('/\[.+?\]/', '', $uri);
            $param = (array) $param;
            if (!empty($param)) {
                $uri .= '/' . join('/', array_map('rawurlencode', $param));
                $uri = str_replace('//', '/', $uri);
            }
            if (!empty($query)) {
                $queryString = http_build_query($query, '', '&', PHP_QUERY_RFC3986);
                $uri .= '?' . $queryString;
            }
            return '/' . $uri;
        } else {
            return null;
        }
    }

    /**
     * Method redirect
     *
     * @param string $controller ControllerClass
     * @param mixed  $param      Param
     * @param array  $query      Query
     *
     * @return void
     */
    public function redirect($controller, $param = null, $query = [], $pushHistory = false)
    {
        $uri = $this->linkto($controller, $param, $query);
        assert(!empty($uri), sprintf('Invalid Controller [%s]', $controller));
        if ($pushHistory) {
            $Session = $this->getSessionManager()->getSession(self::REDIRECT_HISTORY);
            $currentPath = (string) $this->getHttpMessageManager()->getRequest()->getUri();
            $Session[$uri] = $currentPath;
        }
        $this->getHttpMessageManager()
            ->setResponse(new RedirectResponse($uri))
            ->sendResponse();
        // ルータからのリダイレクトは、HttpApplicationから感知できないので
        // 明示的に、HttpApplicationのexitを呼び出す必要がある。
        $this->getObjectManager()
            ->get(HttpApplication::class)
            ->exit();
    }

    public function redirectBack()
    {
        $Session = $this->getSessionManager()->getSession(self::REDIRECT_HISTORY);
        $currentPath = $this->getHttpMessageManager()->getRequest()->getUri()->getPath();
        $redirctBackUri = $Session[$currentPath] ?? null;
        if ($redirctBackUri) {
            $this->getHttpMessageManager()
                ->setResponse(new RedirectResponse($redirctBackUri))
                ->sendResponse();
            $this->getObjectManager()
                ->get(HttpApplication::class)
                ->exit();
        }
    }

    /**
     *  当画面のリダイレク以外をクリアする
     *
     * @return void
     */
    public function resetRedirectHistory()
    {
        $Session = $this->getSessionManager()->getSession(self::REDIRECT_HISTORY);
        $currentPath = $this->getHttpMessageManager()->getRequest()->getUri()->getPath();
        $reset = [
            $currentPath => $Session[$currentPath] ?? null,
        ];
        $Session->exchangeArray($reset);
    }

    /**
     * Method reload
     *
     * @return void
     */
    public function reload($withExit = true)
    {
        $HttpMessageManager = $this->getHttpMessageManager();
        $Request = $HttpMessageManager->getRequest();
        $Uri = $Request->getUri();
        $HttpMessageManager->setResponse(new RedirectResponse($Uri))->sendResponse();
        // ルータからのリダイレクトは、HttpApplicationから感知できないので
        // 明示的に、HttpApplicationのexitを呼び出す必要がある。
        if ($withExit) {
            $this->getObjectManager()
                ->get(HttpApplication::class)
                ->exit();
        }
    }

    /**
     * Method parseRequest
     *
     * @return array $request
     */
    public function parseRequest()
    {
        $action = $param = null;
        $req = $this->getRequestUri();
        if (strpos($req, "?") !== false) {
            list($req) = explode('?', $req);
        }
        if (isset($req[0]) && $req[0] === '/') {
            $req = substr($req, 1);
        }
        if (substr($req, -1, 1) === "/") {
            $req = substr($req, 0, -1);
        }
        $reqs = explode("/", $req);
        $parts = [];
        foreach ($reqs as $idx => $token) {
            //数字で始まる文字列は名前空間やクラス名やメソッド名になり得ないので以降のパラメタを退避させる
            if (isset($token[0]) && is_numeric($token[0])) {
                break;
            }
            $parts[] = $token;
            unset($reqs[$idx]);
        }
        $req = join('/', $parts);
        $action = $this->getIndex();
        $param = array_values($reqs);
        return [
            'req'        => $req,
            'controller' => null,
            'action'     => $action,
            'param'      => $param,
        ];
    }

    /**
     * Method isFaviconRequest
     *
     * @return boolean
     */
    public function isFaviconRequest() : bool
    {
        return $this->getRequestUri() === "/favicon.ico";
    }

    /**
     * Method getRequestUri
     *
     * @return string $request_uri
     */
    public function getRequestUri()
    {
        if ($this->request_uri === null) {
            $this->setRequestUri($_SERVER['REQUEST_URI']);
        }
        return $this->request_uri;
    }

    /**
     * Method setRequestUri
     *
     * @param string $requestUri requestUri
     *
     * @return $this
     */
    public function setRequestUri($requestUri)
    {
        $this->request_uri = $requestUri;
        return $this;
    }

    /**
     * Method getTargetDomain
     *
     * @return string $targetDomain
     */
    public function getTargetDomain()
    {
        return $this->target_domain;
    }

    /**
     * Method setTargetDomain
     *
     * @param string $TargetDomain TargetDomain
     *
     * @return $this
     */
    public function setTargetDomain($TargetDomain)
    {
        $this->target_domain = $TargetDomain;
        return $this;
    }

    /**
     * Method isMatched
     *
     * @return boolean
     */
    public function isMatched() : bool
    {
        return $this->target_domain === $_SERVER['SERVER_NAME'];
    }
}
