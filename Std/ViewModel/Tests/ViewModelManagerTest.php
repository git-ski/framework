<?php

namespace Test\Std\ViewModel;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\ViewModel\ViewModelManager;
use Std\ViewModel\ViewModelInterface;
use Std\ViewModel\EmptyViewModel;
use Std\ViewModel\JsonViewModel;
use Std\Renderer\SafeContent;
use Laminas\Escaper\Escaper;

/**
 * Class ViewModelManagerTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\ViewModel\ViewModelManager
 */
class ViewModelManagerTest extends TestCase
{
    /**
     * @var ViewModelManager $viewModelManager An instance of "ViewModelManager" to test.
     */
    private $viewModelManager;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->viewModelManager = new ViewModelManager();
    }

    /**
     * @covers \Std\ViewModel\ViewModelManager::setBasePath
     */
    public function testSetBasePath(): void
    {
        $expected = __DIR__;

        $property = (new \ReflectionClass($this->viewModelManager))
            ->getProperty('basePath');
        $property->setAccessible(true);
        $this->viewModelManager->setBasePath($expected);

        $this->assertSame($expected, $property->getValue($this->viewModelManager));
    }

    /**
     * @covers \Std\ViewModel\ViewModelManager::getBasePath
     */
    public function testGetBasePath(): void
    {
        $expected = __DIR__;

        $property = (new \ReflectionClass($this->viewModelManager))
            ->getProperty('basePath');
        $property->setAccessible(true);
        $property->setValue($this->viewModelManager, $expected);

        $this->assertSame($expected, $this->viewModelManager->getBasePath());
    }

    /**
     * @covers \Std\ViewModel\ViewModelManager::setTemplateDir
     */
    public function testSetTemplateDir(): void
    {
        $expected = __DIR__;

        $property = (new \ReflectionClass($this->viewModelManager))
            ->getProperty('templateDir');
        $property->setAccessible(true);
        $this->viewModelManager->setTemplateDir($expected);

        $this->assertSame($expected, $property->getValue($this->viewModelManager));
    }

    /**
     * @covers \Std\ViewModel\ViewModelManager::getTemplateDir
     */
    public function testGetTemplateDir(): void
    {
        $expected = __DIR__;

        $property = (new \ReflectionClass($this->viewModelManager))
            ->getProperty('templateDir');
        $property->setAccessible(true);
        $property->setValue($this->viewModelManager, $expected);

        $this->assertSame($expected, $this->viewModelManager->getTemplateDir());
    }

    /**
     * @covers \Std\ViewModel\ViewModelManager::getViewModel
     */
    public function testGetViewModel(): void
    {
        $this->assertTrue(
            $this->viewModelManager->getViewModel([
                'viewModel' => JsonViewModel::class
            ]) instanceof ViewModelInterface
        );
        $this->expectException(\Exception::class);
        $this->viewModelManager->getViewModel([]);
    }

    /**
     * @covers \Std\ViewModel\ViewModelManager::addView
     */
    public function testAddView(): void
    {
        $viewModelMock = $this->createMock(ViewModelInterface::class);
        $this->viewModelManager->addView($viewModelMock);
        $this->expectException(\Exception::class);
        $this->viewModelManager->addView($viewModelMock);
    }

    /**
     * @covers \Std\ViewModel\ViewModelManager::getViewById
     */
    public function testGetViewById(): void
    {
        $this->viewModelManager->addView($this->createMock(ViewModelInterface::class));
        $this->assertNull(
            $this->viewModelManager->getViewById(__FUNCTION__)
        );
        $expected = $this->createMock(ViewModelInterface::class);
        $expected->method('getId')->willReturn(__FUNCTION__);
        $this->viewModelManager->addView($expected);
        $this->assertSame(
            $expected,
            $this->viewModelManager->getViewById(__FUNCTION__)
        );
    }

    /**
     * @covers \Std\ViewModel\ViewModelManager::getIncrementId
     */
    public function testGetIncrementId(): void
    {
        $expected = 0;

        $property = (new \ReflectionClass($this->viewModelManager))
            ->getProperty('incrementId');
        $property->setAccessible(true);
        $property->setValue($this->viewModelManager, $expected);

        $this->assertSame($expected + 1, $this->viewModelManager->getIncrementId());
    }

    /**
     * @covers \Std\ViewModel\ViewModelManager::escapeHtml
     */
    public function testEscapeHtml(): void
    {
        $normalString = 'hello, world';
        $this->assertEquals(
            $normalString,
            $this->viewModelManager->escapeHtml($normalString)
        );
        $dirtyString = '<script>alert(123);</script>';
        $this->assertEquals(
            (new Escaper)->escapeHtml($dirtyString),
            $this->viewModelManager->escapeHtml($dirtyString)
        );
        $noEscape = new \stdClass;
        $safeContent = new SafeContent('safe content');
        $dirtyStrings = [
            '<script>alert(123);</script>',
            '<script>alert(456);</script>',
            $noEscape,
            $safeContent,
        ];
        $this->assertEquals(
            [
                (new Escaper)->escapeHtml($dirtyStrings[0]),
                (new Escaper)->escapeHtml($dirtyStrings[1]),
                $noEscape,
                $safeContent
            ],
            $this->viewModelManager->escapeHtml($dirtyStrings)
        );
    }

    /**
     * @covers \Std\ViewModel\ViewModelManager::getEscaper
     */
    public function testGetEscaper(): void
    {
        $this->assertTrue(
            $this->viewModelManager->getEscaper() instanceof Escaper
        );
    }
}
