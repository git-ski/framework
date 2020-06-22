<?php

namespace Test\Std\Renderer;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\Renderer\TwigRenderer;
use Twig\Environment as Twig;
use Std\ViewModel\ViewModelInterface;

/**
 * Class TwigRendererTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\Renderer\TwigRenderer
 */
class TwigRendererTest extends TestCase
{
    /**
     * @var TwigRenderer $twigRenderer An instance of "TwigRenderer" to test.
     */
    private $twigRenderer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->twigRenderer = ObjectManager::getSingleton()->create(TwigRenderer::class);
    }

    /**
     * @covers \Std\Renderer\TwigRenderer::getTwig
     */
    public function testGetTwig(): void
    {
        $this->assertTrue(
            $this->twigRenderer->getTwig() instanceof Twig
        );
    }

    /**
     * @covers \Std\Renderer\TwigRenderer::render
     */
    public function testRender(): void
    {
        $expected = __DIR__ . '/../phpunit.xml.dist';
        $ViewModel = $this->createMock(ViewModelInterface::class);
        $ViewModel->method('getTemplateForRender')->willReturn($expected);
        $this->assertEquals(
            \file_get_contents($expected),
            $this->twigRenderer->render($ViewModel)
        );
    }
}
