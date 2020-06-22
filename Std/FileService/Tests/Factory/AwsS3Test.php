<?php

namespace Test\Std\FileService\Factory;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FileService\Factory\AwsS3;
use League\Flysystem\AdapterInterface;

/**
 * Class AwsS3Test.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FileService\Factory\AwsS3
 */
class AwsS3Test extends TestCase
{
    /**
     * @var AwsS3 $awsS3 An instance of "AwsS3" to test.
     */
    private $awsS3;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

        $this->awsS3 = new AwsS3();
    }

    /**
     * @covers \Std\FileService\Factory\AwsS3::factory
     */
    public function testFactory(): void
    {
        $adapter = $this->awsS3->factory([
            'region' => 'ap-northeast-1',
            'version' => 'latest',
        ]);
        $this->assertTrue($adapter instanceof AdapterInterface);
    }
}
