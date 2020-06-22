<?php

namespace Test\Std\LoggerManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\LoggerManager\LoggerManagerAwareTrait;
use Std\LoggerManager\LoggerManagerInterface;
use Std\LoggerManager\LoggerManager;

/**
 * Class LoggerManagerAwareTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\LoggerManager\LoggerManagerAwareTrait
 */
class LoggerManagerAwareTraitTest extends TestCase
{
    /**
     * @var LoggerManagerAwareTrait $loggerManagerAwareTrait An instance of "LoggerManagerAwareTrait" to test.
     */
    private $loggerManagerAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

        $this->loggerManagerAwareTrait = $this->getMockBuilder(LoggerManagerAwareTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\LoggerManager\LoggerManagerAwareTrait::setLoggerManager
     */
    public function testSetGetLoggerManager(): void
    {
        $loggerManager = new LoggerManager();
        $this->loggerManagerAwareTrait->setLoggerManager($loggerManager);
        $this->assertSame(
            $loggerManager,
            $this->loggerManagerAwareTrait->getLoggerManager()
        );
    }
}
