<?php
/**
 * PHP version 7
 * File ObjectManagerTest.php
 *
 * @category UnitTest
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Framework\ObjectManager\Tests;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\ObjectManager\SingletonInterface;
use Framework\ObjectManager\FactoryInterface;
use Framework\ObjectManager\Tests\Stub;
use Framework\ObjectManager\Tests\StubClosure;
use Framework\ObjectManager\Tests\StubFactory;
use Framework\ObjectManager\Tests\StubSingleton;
use Framework\ObjectManager\Tests\StubExport;
use Framework\ObjectManager\Tests\StubClass;
use Framework\ObjectManager\Tests\StubInterface;
use Framework\ObjectManager\Tests\StubVirtualInterface;
use Closure;

/**
 * Class ObjectManagerTest
 *
 * @category UnitTest
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class ObjectManager2Test extends TestCase implements
    ObjectManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
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
     * Test testInjectClassDependency
     *
     * @return void
     */
    public function testInjectClassDependency()
    {
        // classのみによる、DIのテスト
        $ObjectManager = $this->getObjectManager();
        // classによる宣言を行う
        $ObjectManager->export([
            StubClass\Test::class => function () {
                return new class extends StubClass\Test {
                };
            }
        ]);
        $Test = $ObjectManager->create(null, function () {
            return new class implements StubClass\TestAwareInterface {
                use StubClass\TestAwareTrait;
            };
        });
        $this->assertInstanceOf(StubClass\Test::class, $Test->getTest());
        $Test2 = $ObjectManager->create(null, function () {
            return new class implements StubClass\TestAwareInterface {
                use StubClass\TestAwareTrait;
            };
        });
        // 別々のObjectが同じInterfaceをInjectできる。
        $this->assertNotEquals($Test, $Test2);
        $this->assertInstanceOf(StubClass\Test::class, $Test2->getTest());
        // 特定の名前としてObjectManagerに保存、およびDIさせる。
        $Test3 = new class implements StubClass\TestAwareInterface {
            use StubClass\TestAwareTrait;
        };
        $ObjectManager->set('test3', $Test3);
        $this->assertNotEquals($Test, $Test3);
        $this->assertNotEquals($Test2, $Test3);
        $this->assertInstanceOf(StubClass\Test::class, $Test3->getTest());
    }
}
