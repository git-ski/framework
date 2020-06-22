<?php

namespace Test\Std\Controller;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\Controller\AbstractConsole;
use Framework\ObjectManager\ObjectManager;
use Std\ViewModel\ViewModelInterface;
use Std\Controller\Tests\Stub\Console;

/**
 * Class AbstractConsoleTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\Controller\AbstractConsole
 */
class AbstractConsoleTest extends TestCase
{
    /**
     * @var AbstractConsole $abstractConsole An instance of "AbstractConsole" to test.
     */
    private $console;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->console = ObjectManager::getSingleton()->create(Console::class);
    }

    /**
     * @covers \Std\Controller\AbstractConsole::callActionFlow
     */
    public function testCallActionFlow(): void
    {
        $this->assertTrue(
            $this->console->callActionFlow('index') instanceof ViewModelInterface
        );
    }

    /**
     * @covers \Std\Controller\AbstractConsole::callActionFlow
     */
    public function testCallActionFlowException(): void
    {
        $this->expectException(\Exception::class);
        $this->console->callActionFlow('invalidAction');
    }

    /**
     * @covers \Std\Controller\AbstractConsole::getDescription
     */
    public function testGetDescription(): void
    {
        $this->assertIsString($this->console->getDescription());
    }

    /**
     * @covers \Std\Controller\AbstractConsole::getHelp
     */
    public function testGetHelp(): void
    {
        $this->assertIsString($this->console->getHelp());
    }

    /**
     * @covers \Std\Controller\AbstractConsole::getPriority
     */
    public function testGetPriority(): void
    {
        $this->assertIsNumeric($this->console->getPriority());
    }
}
