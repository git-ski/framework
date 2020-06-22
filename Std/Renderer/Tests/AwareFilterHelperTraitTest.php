<?php

namespace Test\Std\Renderer;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\Renderer\AwareFilterHelperTrait;
use Std\Renderer\FilterHelper;

/**
 * Class AwareFilterHelperTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\Renderer\AwareFilterHelperTrait
 */
class AwareFilterHelperTraitTest extends TestCase
{
    /**
     * @var AwareFilterHelperTrait $awareFilterHelperTrait An instance of "AwareFilterHelperTrait" to test.
     */
    private $awareFilterHelperTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->awareFilterHelperTrait = $this->getMockBuilder(AwareFilterHelperTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\Renderer\AwareFilterHelperTrait::setFilterHelper
     * @covers \Std\Renderer\AwareFilterHelperTrait::getFilterHelper
     */
    public function testSetGetFilterHelper(): void
    {
        $this->assertTrue(
            $this->awareFilterHelperTrait->getFilterHelper() instanceof FilterHelper
        );
        $expected = $this->createMock(FilterHelper::class);
        $this->awareFilterHelperTrait->setFilterHelper($expected);
        $this->assertSame($expected, $this->awareFilterHelperTrait->getFilterHelper());
    }
}
