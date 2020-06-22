<?php

namespace Test\Std\Renderer;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\Renderer\RendererAwareTrait;
use Std\Renderer\RendererInterface;

/**
 * Class RendererAwareTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\Renderer\RendererAwareTrait
 */
class RendererAwareTraitTest extends TestCase
{
    /**
     * @var RendererAwareTrait $rendererAwareTrait An instance of "RendererAwareTrait" to test.
     */
    private $rendererAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

        $this->rendererAwareTrait = $this->getMockBuilder(RendererAwareTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\Renderer\RendererAwareTrait::setRenderer
     * @covers \Std\Renderer\RendererAwareTrait::getRenderer
     */
    public function testSetGetRenderer(): void
    {
        $expected = $this->createMock(RendererInterface::class);
        $this->rendererAwareTrait->setRenderer($expected);
        $this->assertSame($expected, $this->rendererAwareTrait->getRenderer());
    }
}
