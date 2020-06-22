<?php

namespace Test\Std\SessionManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\SessionManager\SessionManager;
use Laminas\Session\SessionManager as ZfSessionManager;
use Laminas\Session\Container;

/**
 * Class SessionManagerTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\SessionManager\SessionManager
 */
class SessionManagerTest extends TestCase
{
    /**
     * @var SessionManager $sessionManager An instance of "SessionManager" to test.
     */
    private $sessionManager;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->sessionManager = ObjectManager::getSingleton()->create(SessionManager::class);
        $property = (new \ReflectionClass($this->sessionManager))
            ->getProperty('SessionManager');
        $property->setAccessible(true);
        $property->setValue($this->sessionManager, $this->createMock(ZfSessionManager::class));
    }
    /**
     * @covers \Std\SessionManager\SessionManager::getSessionManager
     */
    public function testGetSessionManager(): void
    {
        $this->assertTrue(
            $this->sessionManager->getSessionManager() instanceof ZfSessionManager
        );
    }

    /**
     * @covers \Std\SessionManager\SessionManager::getId
     */
    public function testGetId(): void
    {
        $this->assertEquals(
            $this->sessionManager->getId(),
            $this->sessionManager->getSessionManager()->getId()
        );
    }

    /**
     * @covers \Std\SessionManager\SessionManager::setSession
     * @covers \Std\SessionManager\SessionManager::getSession
     * @covers \Std\SessionManager\SessionManager::hasSession
     * @covers \Std\SessionManager\SessionManager::createContainer
     */
    public function testSetGetSession(): void
    {
        $this->assertFalse(
            $this->sessionManager->hasSession(__CLASS__)
        );
        $this->assertTrue(
            $this->sessionManager->getSession(__CLASS__) instanceof Container
        );
        $this->assertTrue(
            $this->sessionManager->hasSession(__CLASS__)
        );
    }
}
