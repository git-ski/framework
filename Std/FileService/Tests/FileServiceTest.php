<?php

namespace Test\Std\FileService;

use PHPUnit\Framework\MockObject\MockObject;
use Framework\ObjectManager\ObjectManager;
use PHPUnit\Framework\TestCase;
use Std\FileService\FileService;
use Std\FileService\FileSystemFactory;
use League\Flysystem\FilesystemInterface;
use Psr\Http\Message\UploadedFileInterface;
use Std\FileService\FileInterface;
use League\Csv\Reader;
use League\Csv\Writer;

/**
 * Class FileServiceTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FileService\FileService
 */
class FileServiceTest extends TestCase
{
    /**
     * @var FileService $fileService An instance of "FileService" to test.
     */
    private $fileService;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->fileService = ObjectManager::getSingleton()->create(FileService::class);
        $fileSystemFactory = ObjectManager::getSingleton()->create(FileSystemFactory::class);
        $fileSystem = $fileSystemFactory->factory([]);
        $this->fileService->setFileSystem($fileSystem);
    }

    /**
     * @covers \Std\FileService\FileService::getFileSystem
     */
    public function testGetFileSystem(): void
    {
        $fileService = ObjectManager::getSingleton()->create(FileService::class);
        $this->assertTrue($fileService->getFileSystem() instanceof FilesystemInterface);
    }

    /**
     * @covers \Std\FileService\FileService::exists
     */
    public function testExists(): void
    {
        $this->assertTrue(
            $this->fileService->exists(__FILE__)
        );
    }

    /**
     * @covers \Std\FileService\FileService::DumpFile
     * @covers \Std\FileService\FileService::appendToFile
     * @covers \Std\FileService\FileService::load
     * @covers \Std\FileService\FileService::copy
     * @covers \Std\FileService\FileService::remove
     */
    public function testDumpAppendLoadFile(): void
    {
        $testFile = 'temp://test';
        $this->fileService->dumpFile($testFile, 'hello');
        $this->fileService->appendToFile($testFile, ' world');
        $this->assertSame($this->fileService->load($testFile), 'hello world');
        $copyFile = 'temp://test2';
        $this->fileService->copy($testFile, $copyFile);
        $this->assertSame(
            $this->fileService->load($testFile),
            $this->fileService->load($copyFile)
        );
        $this->fileService->remove($testFile);
        $this->fileService->remove($copyFile);
    }

    /**
     */
    public function testLoadFileNotExists() : void
    {
        $notExistsFile = 'temp://notexists';
        $this->expectException(\InvalidArgumentException::class);
        $this->fileService->load($notExistsFile);
    }

    /**
     * @covers \Std\FileService\FileService::validateFilePath
     */
    public function testValidateFilePath(): void
    {
        $file = $this->fileService->validateFilePath(__FILE__);
        $this->assertSame($file, __FILE__);
        $test = $this->fileService->validateFilePath('temp://test');
        $this->assertNotSame($test, 'temp://test');
    }

    /**
     * @covers \Std\FileService\FileService::validateFilePath
     */
    public function testInValidateFilePath(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->fileService->validateFilePath('');
    }

    /**
     * @covers \Std\FileService\FileService::getCsvReader
     */
    public function testGetCsvReader(): void
    {
        $csvFile = 'temp://csv';
        $this->fileService->dumpFile($csvFile, '1, 2, 3,' . PHP_EOL);
        $csv = $this->fileService->getCsvReader($csvFile);
        $this->assertTrue($csv instanceof Reader);
    }

    /**
     * @covers \Std\FileService\FileService::getCsvWriter
     */
    public function testGetCsvWriter(): void
    {
        $csv = $this->fileService->getCsvWriter();
        $this->assertTrue($csv instanceof Writer);
    }

    /**
     * @covers \Std\FileService\FileService::normalizeFile
     */
    public function testNormalizeFile(): void
    {
        $File = $this->fileService->normalizeFile([
            'file' => __FILE__,
            'size' => filesize(__FILE__),
            'clientFilename' => __FILE__,
            'clientMediaType' => 'application/php'
        ]);
        $this->assertTrue($File instanceof UploadedFileInterface);
    }

    /**
     * @covers \Std\FileService\FileService::normalizeFiles
     */
    public function testNormalizeFiles(): void
    {
        [$File] = $this->fileService->normalizeFiles([
            [
                'file' => __FILE__,
                'size' => filesize(__FILE__),
                'clientFilename' => __FILE__,
                'clientMediaType' => 'application/php'
            ]
        ]);
        $this->assertTrue($File instanceof UploadedFileInterface);
        [$normalizedFile] = $this->fileService->normalizeFiles([$File]);
        $this->assertSame($normalizedFile, $File);
    }
}
