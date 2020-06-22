<?php

namespace Test\Std\LoggerManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\LoggerManager\LoggerManager;
use Psr\Log\LoggerInterface;

/**
 * Class LoggerManagerTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\LoggerManager\LoggerManager
 */
class LoggerManagerTest extends TestCase
{
    /**
     * @var LoggerManager $loggerManager An instance of "LoggerManager" to test.
     */
    private $loggerManager;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $ObjectManager = ObjectManager::getSingleton();
        $this->loggerManager = $ObjectManager->get(LoggerManager::class);
    }

    /**
     * @covers \Std\LoggerManager\LoggerManager::get
     * @covers \Std\LoggerManager\LoggerManager::getHandler
     * @covers \Std\LoggerManager\LoggerManager::getLoggerTemplate
     * @covers \Std\LoggerManager\LoggerManager::getConfig
     */
    public function testGet(): void
    {
        $this->assertTrue(
            $this->loggerManager->get('test') instanceof LoggerInterface
        );
    }
}
