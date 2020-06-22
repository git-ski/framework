<?php

namespace Test\Std\ViewModel;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\ViewModel\AbstractViewModel;
use Std\ViewModel\LayoutInterface;
use Std\ViewModel\PageLayout;
use Std\ViewModel\ContainerInterface;
use Std\HttpMessageManager\HttpMessageManager;
use Laminas\I18n\Translator\Translator;

/**
 * Class AbstractViewModelTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\ViewModel\AbstractViewModel
 */
class AbstractViewModelTest extends TestCase
{
    /**
     * @var AbstractViewModel $abstractViewModel An instance of "AbstractViewModel" to test.
     */
    private $abstractViewModel;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->abstractViewModel = $this->getMockBuilder(AbstractViewModel::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        ObjectManager::getSingleton()->injectDependency($this->abstractViewModel);
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::setConfig
     * @covers \Std\ViewModel\AbstractViewModel::getConfig
     */
    public function testSetGetConfig(): void
    {
        $expected = [
            'test' => 'config'
        ];
        $this->abstractViewModel->setConfig($expected);
        $this->assertEquals(
            $expected,
            $this->abstractViewModel->getConfig()
        );
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::init
     */
    public function testInit(): void
    {
        $this->abstractViewModel->setConfig([
            'data' => [
                'test' => 'content'
            ],
            'layout' => PageLayout::class,
            'container' => [
                'test' => [],
            ]
        ]);
        $export = clone $this->abstractViewModel;
        $this->abstractViewModel->init([
            'listeners' => [
                AbstractViewModel::TRIGGER_BEFORE_RENDER => function () {}
            ],
            'exportView' => $export
        ]);
        $this->assertTrue(
            $this->abstractViewModel->getLayout() instanceof PageLayout
        );
        $this->assertSame(
            $export,
            $this->abstractViewModel->getExportView()
        );
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::getId
     */
    public function testGetId(): void
    {
        $expected = "test";

        $property = (new \ReflectionClass(AbstractViewModel::class))
            ->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($this->abstractViewModel, $expected);

        $this->assertSame($expected, $this->abstractViewModel->getId());
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::setTemplate
     * @covers \Std\ViewModel\AbstractViewModel::getTemplate
     */
    public function testSetGetTemplate(): void
    {
        $expected = __FILE__;
        $this->abstractViewModel->setTemplate($expected);
        $this->assertSame($expected, $this->abstractViewModel->getTemplate());
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::setTemplateDir
     * @covers \Std\ViewModel\AbstractViewModel::getTemplateDir
     */
    public function testSetTemplateDir(): void
    {
        $expected = __DIR__;
        $this->abstractViewModel->setTemplateDir($expected);
        $this->assertSame($expected, $this->abstractViewModel->getTemplateDir());
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::getTemplateForRender
     */
    public function testGetTemplateForRender(): void
    {
        $this->assertNull($this->abstractViewModel->getTemplateForRender());
        $expected = __FILE__;
        $this->abstractViewModel->setTemplate($expected);
        $this->assertSame($expected, $this->abstractViewModel->getTemplateForRender());
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::setData
     * @covers \Std\ViewModel\AbstractViewModel::getData
     */
    public function testSetGetData(): void
    {
        $expected = [
            'test' => 'content'
        ];
        $this->abstractViewModel->setData($expected);
        $this->assertSame($expected, $this->abstractViewModel->getData());
        $this->assertSame('content', $this->abstractViewModel->getData('test'));
        $this->assertNull($this->abstractViewModel->getData('invalidKey'));
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::setData
     * @covers \Std\ViewModel\AbstractViewModel::getData
     */
    public function testSetGetExportData(): void
    {
        $expected = [
            'test' => 'content'
        ];
        $export = clone $this->abstractViewModel;
        $this->abstractViewModel->setExportView($export);
        $export->setData($expected);
        $this->assertSame('content', $this->abstractViewModel->getData('test'));
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::render
     */
    public function testRender(): void
    {
        $expected = __FILE__;
        $this->abstractViewModel->setTemplate($expected);
        $this->assertStringContainsString(
            file_get_contents(__FILE__),
            (string) $this->abstractViewModel->render()
        );
        $Layout = $this->createMock(LayoutInterface::class);
        $Layout->method('getContainer')->willReturn($this->createMock(ContainerInterface::class));
        $Layout->method('renderHtml')->willReturn('layout only');
        $this->abstractViewModel->setLayout($Layout);
        $this->assertEquals(
            'layout only',
            (string) $this->abstractViewModel->render()
        );
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::setLayout
     */
    public function testSetGetLayout(): void
    {
        $expected = $this->createMock(LayoutInterface::class);
        $this->abstractViewModel->setConfig([
            'scripts' => ['test'],
            'styles'  => ['test']
        ]);
        $this->abstractViewModel->setLayout($expected);
        $this->assertSame($expected, $this->abstractViewModel->getLayout());
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::setContainers
     * @covers \Std\ViewModel\AbstractViewModel::getContainers
     */
    public function testSetGetContainers(): void
    {
        $expected = $this->createMock(ContainerInterface::class);
        $this->abstractViewModel->setContainers([
            'expected' => $expected,
            'test'     => [],
        ]);
        $this->assertContains(
            $expected,
            $this->abstractViewModel->getContainers()
        );
        $this->assertSame(
            $expected,
            $this->abstractViewModel->getContainer('expected')
        );
        $this->assertTrue(
            $this->abstractViewModel->getContainer('neverSet') instanceof ContainerInterface
        );
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::setContent
     */
    public function testSetContent(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass(AbstractViewModel::class))
            ->getProperty('content');
        $property->setAccessible(true);
        $this->abstractViewModel->setContent($expected);

        $this->assertSame($expected, $property->getValue($this->abstractViewModel));
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::getContent
     */
    public function testGetContent(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass(AbstractViewModel::class))
            ->getProperty('content');
        $property->setAccessible(true);
        $property->setValue($this->abstractViewModel, $expected);

        $this->assertSame($expected, $this->abstractViewModel->getContent());
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::setExportView
     */
    public function testSetExportView(): void
    {
        $expected = $this->createMock(AbstractViewModel::class);

        $property = (new \ReflectionClass(AbstractViewModel::class))
            ->getProperty('exportView');
        $property->setAccessible(true);
        $this->abstractViewModel->setExportView($expected);

        $this->assertSame($expected, $property->getValue($this->abstractViewModel));
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::getExportView
     */
    public function testGetExportView(): void
    {
        $expected = $this->createMock(AbstractViewModel::class);

        $property = (new \ReflectionClass(AbstractViewModel::class))
            ->getProperty('exportView');
        $property->setAccessible(true);
        $property->setValue($this->abstractViewModel, $expected);

        $this->assertSame($expected, $this->abstractViewModel->getExportView());
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::getSecureNonce
     */
    public function testGetSecureNonce(): void
    {
        $this->assertNotEmpty(
            $this->abstractViewModel->getSecureNonce()
        );
        $this->assertIsString(
            $this->abstractViewModel->getSecureNonce()
        );
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::getScoped
     */
    public function testGetScoped(): void
    {
        $this->assertNotEmpty(
            $this->abstractViewModel->getScoped()
        );
        $this->assertIsString(
            $this->abstractViewModel->getScoped()
        );
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::randomStr
     */
    public function testRandomStr(): void
    {
        $this->assertNotEmpty(
            $this->abstractViewModel->randomStr()
        );
        $this->assertIsString(
            $this->abstractViewModel->randomStr()
        );
        $this->assertNotEquals(
            $this->abstractViewModel->randomStr(),
            $this->abstractViewModel->randomStr()
        );
    }

    /**
     * @covers \Std\ViewModel\AbstractViewModel::getTranslator
     */
    public function testGetTranslator(): void
    {
        $this->assertTrue(
            $this->abstractViewModel->getTranslator() instanceof Translator
        );
    }
}
