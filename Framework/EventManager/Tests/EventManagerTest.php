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
namespace Framework\EventManager\Tests;

use PHPUnit\Framework\TestCase;
use Framework\EventManager\Tests\Stub\EventTarget;
use Framework\ObjectManager\ObjectManager;
use Framework\EventManager\Event;
use Framework\EventManager\EventManagerInterface;
use Framework\EventManager\EventManager;
use Framework\EventManager\EventTargetInterface;

/**
 * Class EventManagerTest
 *
 * @category UnitTest
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class EventManagerTest extends TestCase
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
     * Test testEventTarget
     *
     * @return void
     */
    public function testEventTarget()
    {
        $target = new EventTarget;
        $count = 0;
        $eventListener = function ($event) use (&$count) {
            $count++;
            $this->assertEquals(EventTarget::TRIGGER_TEST, $event->getName());
            $this->assertEquals($event, $event->getTarget()->getCurrentEvent());
        };
        $target->addEventListener(
            EventTarget::TRIGGER_TEST,
            $eventListener
        );
        $target->triggerEvent(EventTarget::TRIGGER_TEST);
        $this->assertEquals(1, $count);
        $target->triggerEvent(EventTarget::TRIGGER_TEST);
        $target->triggerEvent(EventTarget::TRIGGER_TEST);
        $this->assertEquals(3, $count);
        // イベントのリスナーは削除可能です。
        $target->removeEventListener(
            EventTarget::TRIGGER_TEST,
            $eventListener
        );
        $target->triggerEvent(EventTarget::TRIGGER_TEST);
        $target->triggerEvent(EventTarget::TRIGGER_TEST);
        $this->assertEquals(3, $count);
        $target->removeEventListener(
            EventTarget::TRIGGER_INIT,
            $eventListener
        );
        $this->assertEquals(3, $count);
        // test setData/getData
        $data = [1, "2", false];
        $target->addEventListener(
            EventTarget::TRIGGER_TEST,
            function ($event) use ($data) {
                $this->assertEquals($data, $event->getData());
            }
        );
        $target->triggerEvent(EventTarget::TRIGGER_TEST, $data);
    }

    /**
     * Test testEventTargetFailture
     *
     * @return void
     */
    public function testEventTargetFailture()
    {
        $target = new EventTarget;
        $count = 0;
        $eventListener = function ($event) use (&$count) {
            $count++;
            $this->assertEquals(EventTarget::TRIGGER_TEST, $event->getName());
            $this->assertEquals($event, $event->getTarget()->getCurrentEvent());
        };
        // 存在しないイベントをリスナーしても、何も起こらない。
        // エラーにもならない。
        $event = 'Invalid Event';
        $target->addEventListener(
            $event,
            $eventListener
        );
        $target->triggerEvent($event);
        $this->assertEquals(0, $count);
    }

    /**
     * Test testEventTargetException
     *
     * @return void
     */
    public function testEventTargetException()
    {
        $this->expectException(\Exception::class);
        $target = new EventTarget;
        // イベントの内部には、同じイベントを発火できない。
        $target->addEventListener(
            EventTarget::TRIGGER_INITED,
            function ($event) {
                $event->getTarget()->triggerEvent(EventTarget::TRIGGER_TEST);
            }
        );
        $target->addEventListener(
            EventTarget::TRIGGER_TEST,
            function ($event) {
                $event->getTarget()->triggerEvent(EventTarget::TRIGGER_INITED);
            }
        );
        $target->triggerEvent(EventTarget::TRIGGER_TEST);
    }

    /**
     * Test testEventManager
     *
     * @return void
     */
    public function testEventManager()
    {
        $eventManager = new EventManager;
        $event = $eventManager->createEvent(EventTarget::TRIGGER_INITED);
        $count = 0;
        $eventListener = function ($event) use (&$count) {
            $count++;
            $this->assertEquals(EventTarget::TRIGGER_INITED, $event->getName());
        };
        // EventTargetInterfaceにTRIGGER_INITEDを定義しており、リスナー可能
        $eventManager->addEventListener(
            EventTargetInterface::class,
            EventTarget::TRIGGER_INITED,
            $eventListener
        );
        $eventManager->dispatchEvent(EventTarget::class, $event);
        $this->assertEquals(1, $count);
        // eventManageにaddEventListenerで追加したリスナーも削除可能
        $eventManager->removeEventListener(
            EventTargetInterface::class,
            EventTarget::TRIGGER_INITED,
            $eventListener
        );
        $eventManager->dispatchEvent(EventTarget::class, $event);
        $this->assertEquals(1, $count);
        // 追加してないリスナーを削除しても、エラーにならない。
        // 削除対象が存在しないため、スルーする。
        $eventManager->removeEventListener(
            EventTargetInterface::class,
            EventTarget::TRIGGER_DEINIT,
            $eventListener
        );
        // EventTargetInterfaceに定義していないイベントはリスナーできない
        $event = $eventManager->createEvent(EventTarget::TRIGGER_TEST);
        // addEventListenerしてもエラーにならないが、何も動作を起こらない
        $eventManager->addEventListener(
            EventTargetInterface::class,
            EventTarget::TRIGGER_TEST,
            $eventListener
        );
        $eventManager->dispatchEvent(EventTarget::class, $event);
        $this->assertEquals(1, $count);
        // しかし、EventTargetTestのClassにTRIGGER_TESTが定義しているため, リスナーはできる
        $eventManager->addEventListener(
            EventTarget::class,
            EventTarget::TRIGGER_TEST,
            function ($event) use (&$count) {
                $count++;
                $this->assertEquals(EventTarget::TRIGGER_TEST, $event->getName());
            }
        );
        $eventManager->dispatchEvent(EventTarget::class, $event);
        $this->assertEquals(2, $count);
    }

    /**
     * Test testEventManagerFailture
     *
     * @return void
     */
    public function testEventManagerFailture()
    {
        $eventManager = new EventManager;
        $count = 0;
        $eventListener = function ($event) use (&$count) {
            $count++;
            $this->assertEquals(EventTarget::TRIGGER_TEST, $event->getName());
            $this->assertEquals($event, $event->getTarget()->getCurrentEvent());
        };
        // EventTargetInterfaceに定義していないイベントはリスナーできない
        $event = 'Invalid Event';
        $eventManager->addEventListener(
            EventTarget::class,
            $event,
            $eventListener
        );
        $eventManager->dispatchEvent(EventTarget::class, $eventManager->createEvent($event));
        $this->assertEquals(0, $count);
    }

    /**
     * Test testEventManagerException
     *
     * @return void
     */
    public function testEventManagerException()
    {
        $this->expectException(\Exception::class);
        $eventManager = new EventManager;
        // イベントの内部には、同じイベントを発火できない。
        $eventManager->addEventListener(
            EventTarget::class,
            EventTarget::TRIGGER_INITED,
            function () use ($eventManager) {
                $eventManager->dispatchEvent(EventTarget::class, $eventManager->createEvent(EventTarget::TRIGGER_TEST));
            }
        );
        $eventManager->addEventListener(
            EventTarget::class,
            EventTarget::TRIGGER_TEST,
            function () use ($eventManager) {
                $eventManager->dispatchEvent(EventTarget::class, $eventManager->createEvent(EventTarget::TRIGGER_INITED));
            }
        );
        $eventManager->dispatchEvent(EventTarget::class, $eventManager->createEvent(EventTarget::TRIGGER_INITED));
    }

    /**
     * Test testEventManager
     * testEventManagerでは、イベントの伝播処理をテスト済み
     * 次は伝播処理の中止やキャンセルをテストする
     *
     * @return void
     */
    public function testConfigurableEvent()
    {
        $event = new Event(
            EventTarget::TRIGGER_INITED,
            [
                'bubbles' => false
            ]
        );
        $this->assertFalse($event->isBubbles());
        $target = new EventTarget;
        $eventManager = new EventManager;
        ObjectManager::getSingleton()->set(EventManagerInterface::class, $eventManager);
        $count = 0;
        $eventListener = function () use (&$count) {
            $count++;
        };
        $eventManager->addEventListener(
            EventTargetInterface::class,
            EventTarget::TRIGGER_INITED,
            $eventListener
        );
        // Eventを伝播不可に設定しているため、そもそも伝播処理が起こらない
        $target->dispatchEvent($event);
        $this->assertEquals(0, $count);
        // ただ、そのEvent自身に対しては、イベントの発火をリスナーできる
        $event = new Event(
            EventTarget::TRIGGER_TEST,
            [
                'bubbles' => false
            ]
        );
        $eventManager->addEventListener(
            EventTarget::class,
            EventTarget::TRIGGER_TEST,
            $eventListener
        );
        $target->dispatchEvent($event);
        $this->assertEquals(1, $count);
        // あるいは、伝播途中で、伝播処理をキャンセルする
        $count = 0;
        $eventManager = new EventManager;
        ObjectManager::getSingleton()->set(EventManagerInterface::class, $eventManager);
        $eventManager->addEventListener(
            EventTargetInterface::class,
            EventTarget::TRIGGER_INITED,
            $eventListener
        );
        $eventManager->addEventListener(
            EventTarget::class,
            EventTarget::TRIGGER_INITED,
            function ($event) {
                $event->stopPropagation();
            }
        );
        $target->triggerEvent(EventTarget::TRIGGER_INITED);
        $this->assertEquals(0, $count);
        // 同じ階層のイベント中に、複数のリスナーが存在する場合、同じ階層内のイベント伝播も中止できる、ただし、優先度を考慮
        $count = 0;
        $eventManager = new EventManager;
        ObjectManager::getSingleton()->set(EventManagerInterface::class, $eventManager);
        $eventManager->addEventListener(
            EventTarget::class,
            EventTarget::TRIGGER_INITED,
            function ($event) {
                $event->preventDefault();
            }
        );
        $eventManager->addEventListener(
            EventTarget::class,
            EventTarget::TRIGGER_INITED,
            $eventListener
        );
        $eventManager->addEventListener(
            EventTarget::class,
            EventTarget::TRIGGER_INITED,
            $eventListener,
            -1
        );
        $target->triggerEvent(EventTarget::TRIGGER_INITED);
        $this->assertEquals(1, $count);
        // 同じ階層の伝播中止、または上層伝播をキャンセルする処理をまとめで行える
        $count = 0;
        $eventManager = new EventManager;
        ObjectManager::getSingleton()->set(EventManagerInterface::class, $eventManager);
        $eventManager->addEventListener(
            EventTargetInterface::class,
            EventTarget::TRIGGER_INITED,
            $eventListener
        );
        $eventManager->addEventListener(
            EventTarget::class,
            EventTarget::TRIGGER_INITED,
            function ($event) {
                $event->stopImmediatePropagation();
            }
        );
        $eventManager->addEventListener(
            EventTarget::class,
            EventTarget::TRIGGER_INITED,
            $eventListener
        );
        $target->triggerEvent(EventTarget::TRIGGER_INITED);
        $this->assertEquals(0, $count);
    }
}
