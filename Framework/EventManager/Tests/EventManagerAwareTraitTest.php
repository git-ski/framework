<?php

namespace Test\Framework\EventManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\EventManager\EventManagerAwareTrait;
use Framework\EventManager\EventManagerInterface;

/**
 * Class EventManagerAwareTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Framework\EventManager\EventManagerAwareTrait
 */
class EventManagerAwareTraitTest extends TestCase
{
    /**
     * @var EventManagerAwareTrait $EventManagerAwareTrait An instance of "EventManagerAwareTrait" to test.
     */
    private $eventManagerAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->eventManagerAwareTrait = $this->getMockBuilder(EventManagerAwareTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Framework\EventManager\EventManagerAwareTrait::setEventManager
     * @covers \Framework\EventManager\EventManagerAwareTrait::getEventManager
     */
    public function testSetGetEventManager(): void
    {
        $this->eventManagerAwareTrait->setEventManager($this->createMock(EventManagerInterface::class));
        $this->assertTrue($this->eventManagerAwareTrait->getEventManager() instanceof EventManagerInterface);
    }
}
