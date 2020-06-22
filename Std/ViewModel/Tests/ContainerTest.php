<?php

namespace Test\Std\ViewModel;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\ViewModel\Container;
use Std\ViewModel\ViewModelInterface;
use Std\ViewModel\EmptyViewModel;

/**
 * Class ContainerTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\ViewModel\Container
 */
class ContainerTest extends TestCase
{
    /**
     * @var Container $container An instance of "Container" to test.
     */
    private $container;
    private $export;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->export = $this->createMock(ViewModelInterface::class);
        $this->container = new Container([], $this->export);
    }

    /**
     * @covers \Std\ViewModel\Container::setItems
     */
    public function testSetGetItems(): void
    {
        $expected = $this->createMock(ViewModelInterface::class);
        $this->container->setItems([
            $expected,
            [
                'viewModel' => EmptyViewModel::class
            ]
        ]);
        $this->assertContains(
            $expected,
            $this->container->getItems()
        );
    }

    /**
     * @covers \Std\ViewModel\Container::setExportView
     */
    public function testSetGetExportView(): void
    {
        $expected = $this->createMock(ViewModelInterface::class);
        $this->container->setExportView($expected);
        $this->assertSame(
            $expected,
            $this->container->getExportView()
        );
    }

    /**
     * @covers \Std\ViewModel\Container::getContent
     */
    public function testGetContent(): void
    {
        $expected = 'content';
        $item = $this->createMock(ViewModelInterface::class);
        $item->method('render')->willReturn($expected);
        $this->container->setItems([
            $item,
            $item
        ]);
        $this->assertEquals(
            $expected . $expected,
            $this->container->getContent()
        );
    }

    /**
     * @covers \Std\ViewModel\Container::get
     */
    public function testGet(): void
    {
        $expected = 'test';
        $item = $this->createMock(ViewModelInterface::class);
        $item->method('getId')->willReturn($expected);
        $this->container->setItems([
            $item,
            $this->createMock(ViewModelInterface::class)
        ]);
        $this->assertSame(
            $item,
            $this->container->get($expected)
        );
    }

    /**
     * @covers \Std\ViewModel\Container::has
     */
    public function testHas(): void
    {
        $expected = 'test';
        $item = $this->createMock(ViewModelInterface::class);
        $item->method('getId')->willReturn($expected);
        $this->container->setItems([
            $item,
            $this->createMock(ViewModelInterface::class)
        ]);
        $this->assertTrue(
            $this->container->has($expected)
        );
    }
}
