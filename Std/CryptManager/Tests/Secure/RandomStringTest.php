<?php

namespace Test\Std\CryptManager\Secure;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\CryptManager\Secure\RandomString;

/**
 * Class RandomStringTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\CryptManager\Secure\RandomString
 */
class RandomStringTest extends TestCase
{
    /**
     * @var RandomString $randomString An instance of "RandomString" to test.
     */
    private $randomString;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->randomString = new RandomString();
    }

    /**
     * @covers \Std\CryptManager\Secure\RandomString::generate
     */
    public function testGenerate(): void
    {
        $randomString = $this->randomString->generate(10);
        $this->assertTrue(10 === strlen($randomString));
        $this->assertNotSame($randomString, $this->randomString->generate(10));
    }
}
