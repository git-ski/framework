<?php

namespace Test\Std\SessionManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\SessionManager\FlashMessage;
use Framework\ObjectManager\ObjectManager;
use Std\SessionManager\SessionManager;
use Laminas\Session\SessionManager as ZfSessionManager;

/**
 * Class FlashMessageTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\SessionManager\FlashMessage
 */
class FlashMessageTest extends TestCase
{
    /**
     * @var FlashMessage $flashMessage An instance of "FlashMessage" to test.
     */
    private $flashMessage;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->flashMessage = new FlashMessage();
        $sessionManager = ObjectManager::getSingleton()->create(SessionManager::class);
        $property = (new \ReflectionClass($sessionManager))
            ->getProperty('SessionManager');
        $property->setAccessible(true);
        $property->setValue($sessionManager, $this->createMock(ZfSessionManager::class));
        $this->flashMessage->setSessionManager($sessionManager);
    }

    /**
     * @covers \Std\SessionManager\FlashMessage::add
     */
    public function testAdd(): void
    {
        $this->assertFalse(
            $this->flashMessage->has(__CLASS__)
        );
        $this->flashMessage->add(__CLASS__, __METHOD__);
        $this->assertTrue(
            $this->flashMessage->has(__CLASS__)
        );
        $this->assertEquals(
            __METHOD__,
            $this->flashMessage->__invoke(__CLASS__)
        );
        // 一旦取り出すと、flashmessageの中に存在しなくなる
        $this->assertFalse(
            $this->flashMessage->has(__CLASS__)
        );
    }
}
