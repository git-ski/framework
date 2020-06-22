<?php

namespace Test\Std\Renderer;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\Renderer\FilterHelper;

/**
 * Class FilterHelperTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\Renderer\FilterHelper
 */
class FilterHelperTest extends TestCase
{
    /**
     * @var FilterHelper $filterHelper An instance of "FilterHelper" to test.
     */
    private $filterHelper;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->filterHelper = new FilterHelper();
    }

    /**
     * @covers \Std\Renderer\FilterHelper::addFilter
     */
    public function testAddGetFilter(): void
    {
        $expected = function ($value) {
            return $value;
        };
        $this->filterHelper->addFilter('test', $expected);
        $this->assertSame(
            $expected,
            $this->filterHelper->getFilter('test')
        );
        $this->assertEquals([
            'test' => $expected
        ], $this->filterHelper->getFilters());
    }
}
