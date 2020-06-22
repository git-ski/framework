<?php

namespace Test\Std\Renderer;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\Renderer\SafeContent;

/**
 * Class SafeContentTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\Renderer\SafeContent
 */
class SafeContentTest extends TestCase
{
    /**
     * @covers \Std\Renderer\SafeContent::__construct
     * @covers \Std\Renderer\SafeContent::__toString
     */
    public function testToString(): void
    {
        $expected = 'content';
        $safeContent = new SafeContent($expected);
        $this->assertEquals(
            $expected,
            (string) $safeContent
        );
    }
}
