<?php

namespace Test\Std\FileService;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FileService\FileServiceAwareTrait;
use Std\FileService\FileServiceInterface;
use Std\FileService\FileService;

/**
 * Class FileServiceAwareTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FileService\FileServiceAwareTrait
 */
class FileServiceAwareTraitTest extends TestCase
{
    /**
     * @var FileServiceAwareTrait $fileServiceAwareTrait An instance of "FileServiceAwareTrait" to test.
     */
    private $fileServiceAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->fileServiceAwareTrait = $this->getMockBuilder(FileServiceAwareTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\FileService\FileServiceAwareTrait::setFileService
     */
    public function testSetGetFileService(): void
    {
        $this->fileServiceAwareTrait->setFileService(new FileService());
        $this->assertTrue(
            $this->fileServiceAwareTrait->getFileService() instanceof FileServiceInterface
        );
    }
}
