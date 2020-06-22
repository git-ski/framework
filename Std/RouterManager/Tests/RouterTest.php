<?php
/**
 * PHP version 7
 * File EventManagerTest.php
 *
 * @category UnitTest
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\RouterManager\Tests;

use PHPUnit\Framework\TestCase;
use Std\RouterManager\RouterManager;
use Std\RouterManager\RouterInterface;
use Std\RouterManager\RouterManagerInterface;
use Std\RouterManager\Http\Router as HttpRouter;
use Std\RouterManager\Console\Router as ConsoleRouter;
use Framework\ObjectManager\ObjectManager;
use Std\RouterManager\Tests\Stub\MockController;
use Std\RouterManager\Tests\Stub\InvalidMockController;
use Std\RouterManager\Tests\Stub\ConsoleMockController;

/**
 * Class RouterTest
 *
 * @category UnitTest
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class RouterTest extends TestCase
{
    /**
    * setUpBeforeClass
    *
    * @api
    * @access
    * @return  null
    * @example
    * @since
    */
    public static function setUpBeforeClass() : void
    {
    }

    /**
    * tearDownAfterClass
    *
    * @api
    * @access
    * @return  null
    * @example
    * @since
    */
    public static function tearDownAfterClass() : void
    {
    }

    /**
     * Test testHttpRouter
     *
     * @return void
     */
    public function testHttpRouter()
    {
        $routeList = [
            'test' => MockController::class,
            'test/index' => MockController::class
        ];
        // 最初のルータ
        $Router = $this->reCreateRouter(HttpRouter::class);
        $Router->setRouterList($routeList);
        $Router->setRequestUri('test/index');
        $request = $Router->dispatch();
        $this->assertArrayHasKey('controller', $request);
        $this->assertArrayHasKey('action', $request);
        $this->assertEquals($request['controller'], MockController::class);
        // もう１つのルータ
        // アプリ上、ルート結果はルータ内部に維持するため、テストごとルータを生成する
        $Router = $this->reCreateRouter(HttpRouter::class);
        $Router->setRouterList($routeList);
        $Router->setRequestUri('test');
        $request = $Router->dispatch();
        $this->assertArrayHasKey('controller', $request);
        $this->assertArrayHasKey('action', $request);
        $this->assertEquals($request['controller'], MockController::class);
        // 各モジュールのルート設定は別々で登録可能
        $Router = $this->reCreateRouter(HttpRouter::class);
        $Router->register(
            [
                'test' => MockController::class
            ]
        );
        $Router->register(
            [
                'test/index' => MockController::class
            ]
        );
        $this->assertEquals($routeList, $Router->getRouterList());
        $Router->setRequestUri('test');
        $request = $Router->dispatch();
        $this->assertArrayHasKey('controller', $request);
        $this->assertArrayHasKey('action', $request);
        $this->assertEquals($request['controller'], MockController::class);
        // デフォルトのRouteはindex
        $routeList = [
            'index' => MockController::class,
        ];
        $Router = $this->reCreateRouter(HttpRouter::class);
        $Router->setRouterList($routeList);
        // requestUriが空白文字列（一般的にトップ画面とか）、デフォルトのrouteにdispatchする
        $Router->setRequestUri('index');
        $request = $Router->dispatch();
        $this->assertArrayHasKey('controller', $request);
        $this->assertArrayHasKey('action', $request);
        $this->assertEquals($request['controller'], MockController::class);
        // そして、faviconのリクエストも素早く判定しないといけない。
        // faviconの設定ミスは人的なミスで発生しやすいため
        // このリクエストを毎回アプリにdispatchすると、無駄にサーバーリソースを消費する
        $Router = $this->reCreateRouter(HttpRouter::class);
        $Router->setRequestUri('/favicon.ico');
        $this->assertTrue($Router->isFaviconRequest());
    }

    /**
     * Test testHttpRouterRedirect
     */
    public function testHttpRouterRedirect()
    {
        $this->expectException(\Exception::class);
        $routeList = [
            'index' => MockController::class,
        ];
        $Router = $this->reCreateRouter(HttpRouter::class);
        $Router->setRouterList($routeList);
        $requestUri = 'index/1';
        // ルーターを利用して、コントローラーからurlを逆引きできる
        $uri = $Router->linkto(MockController::class, 1);
        $this->assertEquals($uri, '/index/1');
        // UnitTestにはリダイレクトできないので、Exceptionを予期する
        $Router->redirect(MockController::class, 1);
        $this->assertContains(
            "Location: /$requestUri", headers_list()
        );
    }

    /**
     * Test testHttpRouterRedirect
     */
    public function testHttpRouterRedirect2()
    {
        $this->expectException(\Exception::class);
        $routeList = [
            'index' => MockController::class,
        ];
        $Router = $this->reCreateRouter(HttpRouter::class);
        $Router->setRouterList($routeList);
        $requestUri = 'index/1';
        $Router->setRequestUri($requestUri);
        $Router->dispatch();
        // ルーターを利用して、コントローラーからurlを逆引きできる
        $uri = $Router->linkto(MockController::class, 1);
        $this->assertEquals($uri, '/index/1');
        // UnitTestにはリダイレクトできないので、Exceptionを予期する
        $Router->reload();
        $this->assertContains(
            "Location: /$requestUri", headers_list()
        );
    }

    /**
     * Test testHttpRouterRedirectException
     *
     * @return void
     */
    public function testHttpRouterRedirectException()
    {
        $routeList = [
            'index' => MockController::class,
        ];
        $Router = $this->reCreateRouter(HttpRouter::class);
        $Router->setRouterList($routeList);
        $requestUri = 'index/1';
        $Router->setRequestUri($requestUri);
        $Router->dispatch();
        // コントローラーの逆引きで、みつからない場合はnullを返す
        $this->assertNull($Router->linkto(InValidMockController::class));
    }

    /**
     * Test testHttpRouterForApplication
     *
     * 実アプリのRouteをテスト
     * RouterをObjectManagerに登録することで、DIさせる。
     *
     * @return void
     */
    public function testHttpRouterForApplication()
    {
        $Router = $this->reCreateRouter(HttpRouter::class);
        // 実アプリでは、各モジュールからRouteを登録する
        // uriは$_SERVER['REQUEST_URI']から取得
        $_SERVER['REQUEST_URI'] = '//';
        $request = $Router->dispatch();
        $this->assertArrayHasKey('controller', $request);
        $this->assertArrayHasKey('action', $request);
        // ルータ結果はリクエストごとにキャッシュされるので、再度取得してもコストかからない
        $request2 = $Router->getRequest();
        $this->assertEquals($request, $request2);
        // URLに?が存在する場合、Queryとして処理する必要がある
        $Router = $this->reCreateRouter(HttpRouter::class);
        $Router->setRequestUri('?test=2');
        $request2 = $Router->dispatch();
        $this->assertArrayHasKey('controller', $request);
        $this->assertArrayHasKey('action', $request);
        $this->assertEquals($request, $request2);
        $request3 = $Router->getRequest();
        $this->assertEquals($request3, $request2);
        // 一方、実際のdispatchよりも前に、ルータ結果を明示的に設定することも可能
        // メンテナンス画面を出す処理を介入させたい場合とか
        $Router = $this->reCreateRouter(HttpRouter::class);
        $param = [
            'controller' => MockController::class,
            'action' => 'index',
            'param' => []
        ];
        $Router->setRequest($param);
        $request = $Router->getRequest();
        $this->assertArrayHasKey('controller', $request);
        $this->assertArrayHasKey('action', $request);
        $this->assertEquals($param, $request);
        // それに、ルータ結果の項目を取ることも可能、実際、アプリ上あまり利用されることはないでしょう
        $this->assertEquals($Router->getController(), MockController::class);
        $this->assertEquals($Router->getAction(), 'index');
    }

    /**
     * Test testHttpRouterMatch
     * キャッシュキーが重複登録するとエラーになるため、別プロセスでテストを実行。
     *
     * @return void
     */
    public function testHttpRouterMatch()
    {
        $Router = $this->reCreateRouter(HttpRouter::class);
        $testDomain = 'test.secure.local';
        $Router->setTargetDomain($testDomain);
        $_SERVER['SERVER_NAME'] = $testDomain;
        $this->assertEquals($testDomain, $Router->getTargetDomain());
        $this->assertTrue($Router->isMatched());
        $_SERVER['SERVER_NAME'] = 'unmatch.secure.local';
        $this->assertFalse($Router->isMatched());
    }

    /**
     * Test testHttpRouterFailture
     * キャッシュキーが重複登録するとエラーになるため、別プロセスでテストを実行。
     *
     * @return void
     */
    public function testHttpRouterFailture()
    {
        $Router = $this->reCreateRouter(HttpRouter::class);
        $Router->setRequestUri('index.php');
        $request = $Router->dispatch();
        $this->assertArrayHasKey('controller', $request);
        $this->assertArrayHasKey('action', $request);
        $this->assertEmpty($request['controller']);
        // actionはindex固定にインターフェース変更
        $this->assertEquals('index', $request['action']);
    }
    /**
     * Test testConsoleRouterForApplication
     *　コンソールのルータをテストする
     *
     * @return void
     */
    public function testConsoleRouterForApplication()
    {
        $Router = $this->reCreateRouter(ConsoleRouter::class);
        // Consoleパラメータ
        $_SERVER['argv'] = ['action', 'param=123'];
        $request = $Router->dispatch();
        $this->assertArrayHasKey('controller', $request);
        $this->assertArrayHasKey('action', $request);
    }

    /**
     * Test testConsoleRouterException
     *
     * @return void
     */
    public function testConsoleRouterException()
    {
        $this->expectException(\Exception::class);
        $Router = $this->reCreateRouter(ConsoleRouter::class);
        $routeList = [
            'test' => ConsoleMockController::class
        ];
        $Router->setRouterList($routeList);
        $Router->setParam([]);
        $Router->dispatch();
        $Router->redirect(ConsoleMockController::class);
    }

    /**
     * コンソールのルータでは、パラメータの渡し方が非常に重要です。
     *
     * key-valueの渡し方
     * php bin/console.php a=1 b=2 c="select * from test where test_id = 123";
     *
     * フラットパラメータの渡し方
     * php bin/console.php help list
     *
     * 両方ともテストするように
     *
     * @return void
     */
    public function testConsoleRouterParam1()
    {
        // key-valueの渡し方
        $Router = $this->reCreateRouter(ConsoleRouter::class);
        $Router->setRouterList([
            'testcommand' => MockController::class
        ]);
        $_SERVER['argv'] = [
            'bin/console.php',
            'testcommand',
            'a=1',
            'b=2',
            'c="select * from test where test_id = 123"',
        ];
        $request = $Router->dispatch();
        $this->assertEquals(MockController::class, $request['controller']);
        $this->assertEquals([
            'a' => '1',
            'b' => '2',
            'c' => '"select * from test where test_id = 123"'
        ], $request['param'][0]);
    }

    /**
     *
     * @return void
     */
    public function testConsoleRouterParam2()
    {
        // フラットパラメータの渡し方
        $Router = $this->reCreateRouter(ConsoleRouter::class);
        $Router->setRouterList([
            'testcommand' => MockController::class
        ]);
        $_SERVER['argv'] = [
            'bin/console.php',
            'controller',
            'command1',
            'command2',
        ];
        $request = $Router->dispatch();
        $this->assertEquals([
            'command1',
            'command2',
        ], $request['param'][0]);
    }

    private function reCreateRouter($RouterClass)
    {
        $ObjectManager = ObjectManager::getSingleton();
        $RouterManager = $ObjectManager->create(RouterManager::class);
        $Router        = new $RouterClass;
        $RouterManager->register('Std\RouterManager', $Router);
        $ObjectManager->set(RouterInterface::class, $Router);
        $ObjectManager->set(RouterManagerInterface::class, $RouterManager);
        return $Router;
    }
}
