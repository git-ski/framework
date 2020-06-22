<?php

namespace Test\Std\Renderer;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\Renderer\Renderer;
use Std\ViewModel\ViewModelInterface;

/**
 * Class RendererTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\Renderer\Renderer
 */
class RendererTest extends TestCase
{
    /**
     * @var Renderer $renderer An instance of "Renderer" to test.
     */
    private $renderer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->renderer = ObjectManager::getSingleton()->create(Renderer::class);
    }

    /**
     * @covers \Std\Renderer\Renderer::render
     */
    public function testRender(): void
    {
        $expected = __DIR__ . '/../phpunit.xml.dist';
        $ViewModel = $this->createMock(ViewModelInterface::class);
        $ViewModel->method('getTemplateForRender')->willReturn($expected);
        $this->assertEquals(
            \file_get_contents($expected),
            $this->renderer->render($ViewModel)
        );
    }

    /**
     * @covers \Std\Renderer\Renderer::__call
     */
    public function testCall(): void
    {
        $this->renderer->getFilterHelper()->addFilter('trim', function ($value) {
            return trim($value);
        });
        $expected = '  test  ';
        $this->assertEquals(
            trim($expected),
            $this->renderer->trim($expected)
        );
    }
}
