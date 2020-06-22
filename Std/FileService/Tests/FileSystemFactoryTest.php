<?php

namespace Test\Std\FileService;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FileService\FileSystemFactory;
use League\Flysystem\FilesystemInterface;
use Framework\ObjectManager\ObjectManager;

/**
 * Class FileSystemFactoryTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FileService\FileSystemFactory
 */
class FileSystemFactoryTest extends TestCase
{
    /**
     * @var FileSystemFactory $fileSystemFactory An instance of "FileSystemFactory" to test.
     */
    private $fileSystemFactory;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->fileSystemFactory = ObjectManager::getSingleton()->get(FileSystemFactory::class);
    }

    /**
     * @covers \Std\FileService\FileSystemFactory::factory
     */
    public function testFactory(): void
    {
        $FileSystem = $this->fileSystemFactory->factory([
            'sync' => [
                [], [], []
            ]
        ]);
        $this->assertTrue($FileSystem instanceof FilesystemInterface);
    }
}
