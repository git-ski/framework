<?php

namespace Test\Std\FileService\Factory;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FileService\Factory\Local;
use League\Flysystem\AdapterInterface;

/**
 * Class LocalTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FileService\Factory\Local
 */
class LocalTest extends TestCase
{
    /**
     * @var Local $local An instance of "Local" to test.
     */
    private $local;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

        $this->local = new Local();
    }

    /**
     * @covers \Std\FileService\Factory\Local::factory
     */
    public function testFactory(): void
    {
        $adapter = $this->local->factory();
        $this->assertTrue($adapter instanceof AdapterInterface);
    }
}
