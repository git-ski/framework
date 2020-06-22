<?php

namespace Test\Std\FileService\Factory;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FileService\Factory\Replicate;
use League\Flysystem\Adapter\Local;
use League\Flysystem\AdapterInterface;

/**
 * Class ReplicateTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FileService\Factory\Replicate
 */
class ReplicateTest extends TestCase
{
    /**
     * @var Replicate $replicate An instance of "Replicate" to test.
     */
    private $replicate;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

        $this->replicate = new Replicate();
    }

    /**
     * @covers \Std\FileService\Factory\Replicate::factory
     */
    public function testFactory(): void
    {
        $LocalMock = $this->getMockBuilder(Local::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        $replicaMocks = array_map(function () {
            return $this->getMockBuilder(Local::class)
                ->disableOriginalConstructor()
                ->getMock();
        }, [null, null, null]);
        $adapter = $this->replicate->factory($LocalMock, $replicaMocks);
        $this->assertTrue($adapter instanceof AdapterInterface);
    }
}
