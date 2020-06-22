<?php

namespace Test\Std\FileService\Factory;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FileService\Factory\Sftp;
use League\Flysystem\AdapterInterface;

/**
 * Class SftpTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FileService\Factory\Sftp
 */
class SftpTest extends TestCase
{
    /**
     * @var Sftp $sftp An instance of "Sftp" to test.
     */
    private $sftp;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

        $this->sftp = new Sftp();
    }

    /**
     * @covers \Std\FileService\Factory\Sftp::factory
     */
    public function testFactory(): void
    {
        $adapter = $this->sftp->factory([]);
        $this->assertTrue($adapter instanceof AdapterInterface);
    }
}
