<?php
/**
 * PHP version 7
 * File Std\UploadedFileDecorator.php
 *
 * @category FileService
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\FileService;

use Psr\Http\Message\UploadedFileInterface;
use Std\FileService\FileInterface;

/**
 * Class UploadedFileDecorator
 * @codeCoverageIgnore
 * @category FileService
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class FileDecorator implements
    FileInterface
{
    /**
     * @var UploadedFileInterface
     */
    protected $wrapped;

    /**
     * 内部で維持するファイルパス
     *
     * @var string
     */
    private $file;

    /**
     * ファイルのUuid
     *
     * @var string
     */
    private $uuid;


    /**
     * @param UploadedFileInterface $wrapped
     */
    public function __construct(UploadedFileInterface $wrapped)
    {
        $this->wrapped = $wrapped;
    }

    /**
     * {@inheritDoc}
     */
    public function getStream()
    {
        return $this->wrapped->getStream();
    }

    /**
     * {@inheritDoc}
     */
    public function moveTo($targetPath)
    {
        $this->file = $targetPath;
        return $this->wrapped->moveTo($targetPath);
    }

    /**
     * {@inheritDoc}
     */
    public function getSize()
    {
        return $this->wrapped->getSize();
    }

    /**
     * {@inheritDoc}
     */
    public function getError()
    {
        return $this->wrapped->getError();
    }

    /**
     * {@inheritDoc}
     */
    public function getClientFilename()
    {
        return $this->wrapped->getClientFilename();
    }

    /**
     * {@inheritDoc}
     */
    public function getClientMediaType()
    {
        return $this->wrapped->getClientMediaType();
    }

    /**
     * @return string
     */
    public function getFile()
    {
        if (null === $this->file) {
            // trick!
            //  UploadedFileInterfaceオブジェクトの内部プロパティを取得
            // 実質に、Laminas\Diactoros\UploadedFileの内部実装に依存しており
            $this->file = (function () {
                return $this->file;
            })->call($this->wrapped);
        }
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    public function getUuid()
    {
        return $this->uuid;
    }
}
