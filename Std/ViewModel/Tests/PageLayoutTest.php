<?php

namespace Test\Std\ViewModel;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\ViewModel\PageLayout;
use Std\ViewModel\ViewModelManager;

/**
 * Class PageLayoutTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\ViewModel\PageLayout
 */
class PageLayoutTest extends TestCase
{
    /**
     * @var PageLayout $pageLayout An instance of "PageLayout" to test.
     */
    private $pageLayout;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->pageLayout = new PageLayout();
        $ViewModelManagerMock = $this->createMock(ViewModelManager::class);
        $ViewModelManagerMock->method('getBasePath')->willReturn('base/');
        $this->pageLayout->setViewModelManager($ViewModelManagerMock);
    }

    /**
     * @covers \Std\ViewModel\PageLayout::getStyle
     */
    public function testGetStyle(): void
    {
        $input = [
            'style 1',
            'style 2',
            'https://style 3',
        ];
        $expected = [
            '//base/style 1',
            '//base/style 2',
            'https://style 3',
        ];
        $this->pageLayout->registerStyle($input[0]);
        $this->pageLayout->registerStyle($input[1]);
        $this->pageLayout->registerStyle($input[2]);
        // 重複挿入は自動で除外
        $this->pageLayout->registerStyle($input[0]);
        $this->pageLayout->registerStyle($input[1]);
        $this->pageLayout->registerStyle($input[2]);
        $this->assertEquals(
            $expected,
            $this->pageLayout->getStyle()
        );
    }

    /**
     * @covers \Std\ViewModel\PageLayout::getScript
     */
    public function testGetScript(): void
    {
        $input = [
            'script 1',
            'script 2',
            'https://script 3',
        ];
        $expected = [
            '//base/script 1',
            '//base/script 2',
            'https://script 3',
        ];
        $this->pageLayout->registerScript($input[0]);
        $this->pageLayout->registerScript($input[1]);
        $this->pageLayout->registerScript($input[2]);
        // 重複挿入は自動で除外
        $this->pageLayout->registerScript($input[0]);
        $this->pageLayout->registerScript($input[1]);
        $this->pageLayout->registerScript($input[2]);
        $this->assertEquals(
            $expected,
            $this->pageLayout->getScript()
        );
    }

    /**
     * @covers \Std\ViewModel\PageLayout::setAsset
     */
    public function testSetAsset(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->pageLayout))
            ->getProperty('asset');
        $property->setAccessible(true);
        $this->pageLayout->setAsset($expected);

        $this->assertSame($expected, $property->getValue($this->pageLayout));
    }

    /**
     * @covers \Std\ViewModel\PageLayout::getAsset
     */
    public function testGetAsset(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->pageLayout))
            ->getProperty('asset');
        $property->setAccessible(true);
        $property->setValue($this->pageLayout, $expected);

        $this->assertSame($expected, $this->pageLayout->getAsset());
    }
}
