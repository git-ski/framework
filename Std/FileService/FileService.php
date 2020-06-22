<?php
/**
 * PHP version 7
 * File Std\FileService.php
 *
 * @category FileService
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\FileService;

use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Psr\Http\Message\UploadedFileInterface;
use League\Flysystem\FilesystemInterface;
use League\Csv\Reader as CsvReader;
use League\Csv\Writer as CsvWriter;
use League\Csv\EncloseField;
use League\Csv\EscapeFormula;
use InvalidArgumentException;
use Std\FileService\FileInterface;
use Ramsey\Uuid\Uuid;
use function Laminas\Diactoros\normalizeUploadedFiles;

/**
 * Class FileService
 *
 * @category FileService
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class FileService implements
    FileServiceInterface,
    CryptManagerAwareInterface,
    ConfigManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\CryptManager\CryptManagerAwareTrait;

    const DEFAULT_SCHEMA = [
        'public://' => ROOT_DIR . 'public/',
        'private://'=> ROOT_DIR . 'var/private/',
        'temp://'   => ROOT_DIR . 'var/temp/',
        'data://'   => ROOT_DIR . 'var/data/',
        'log://'    => ROOT_DIR . 'var/log/'
    ];

    private $fileSystem;
    private $schema;

    /**
     * {@inheritDoc}
     */
    public function getFileSystem() : FilesystemInterface
    {
        if (null === $this->fileSystem) {
            $this->fileSystem = FileSystemFactory::factory(
                $this->getConfigManager()->getConfig('file')
            );
        }
        return $this->fileSystem;
    }

    public function setFileSystem(FilesystemInterface $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function exists($relativePaths)
    {
        $absolutePath = $this->validateFilePath($relativePaths);
        return $this->getFileSystem()->has($absolutePath);
    }

    /**
     * {@inheritDoc}
     */
    public function dumpFile(string $relativePath, $content)
    {
        $absolutePath = $this->validateFilePath($relativePath);
        $content = (string) $content;
        $this->getFileSystem()->put($absolutePath, $content);
    }

    /**
     * {@inheritDoc}
     */
    public function appendToFile(string $relativePath, $content)
    {
        $absolutePath = $this->validateFilePath($relativePath);
        $content = (string) $content;
        $this->getFileSystem()->update(
            $absolutePath,
            $this->load($absolutePath) . $content
        );
    }


    /**
     * {@inheritDoc}
     */
    public function load(string $relativePath) : string
    {
        $absolutePath = $this->validateFilePath($relativePath);
        if (!file_exists($absolutePath)) {
            throw new InvalidArgumentException(sprintf('ファイル存在しない: %s', $relativePath));
        }
        return $this->getFileSystem()->read($absolutePath);
    }

    /**
     * {@inheritDoc}
     */
    public function copy(string $source, string $destination)
    {
        $absoluteSource      = $this->validateFilePath($source);
        $absoluteDestination = $this->validateFilePath($destination);
        $this->getFileSystem()->copy($absoluteSource, $absoluteDestination);
    }

    /**
     * {@inheritDoc}
     */
    public function remove($files)
    {
        $files = (array) $files;
        foreach ($files as $file) {
            if ($file instanceof FileInterface) {
                $path = $this->validateFilePath($file->getFile());
            } else {
                $path = $this->validateFilePath($file);
            }
            $this->getFileSystem()->delete($path);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function moveUploadedFile(UploadedFileInterface $UploadedFile) : string
    {
        $targetSchema = 'temp://';
        // ユニークなランダムファイル名を生成、 タイムスタンプも考慮する
        $destination  = $targetSchema . uniqid($this->getCryptManager()->getRandomString()->generate(16));
        $this->dumpFile($destination, $UploadedFile->getStream());
        return $destination;
    }

    /**
     * {@inheritDoc}
     */
    public function validateFilePath(string $relativeOrAbsolutePath) : string
    {
        $absolutePath = $relativeOrAbsolutePath;
        foreach ($this->getSchema() as $relative => $absolute) {
            if (strpos($relativeOrAbsolutePath, $relative) === 0) {
                $absolutePath = str_replace($relative, $absolute, $relativeOrAbsolutePath);
                break;
            }
        }
        if (!$absolutePath) {
            throw new InvalidArgumentException(sprintf('無効なファイルパス: %s', $relativeOrAbsolutePath));
        }
        return $absolutePath;
    }

    public function getCsvReader($relativeOrAbsolutePath)
    {
        $absolutePath = $this->validateFilePath($relativeOrAbsolutePath);
        return CsvReader::createFromPath($absolutePath, 'r');
    }

    public function getCsvWriter()
    {
        $writer = CsvWriter::createFromPath('php://temp', 'wr+');
        $writer->addFormatter(new EscapeFormula());
        EncloseField::addTo($writer, "\t\x1f");
        return $writer;
    }

    /**
     * {@inheritDoc}
     */
    public function normalizeFile(array $fileInfo): FileInterface
    {
        $fileInfo = $this->satisfyFileSpec($fileInfo);
        [$File] = normalizeUploadedFiles([$fileInfo]);
        $FileDecorator = new FileDecorator($File);
        $FileDecorator->setFile($fileInfo['tmp_name']);
        if (empty($fileInfo['uuid'])) {
            // uuidが無ければ、ファイルコンテンツから生成する。
            $FileContent = $this->load($FileDecorator->getFile());
            $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, $FileContent)->toString();
            $FileDecorator->setUuid($uuid);
        }
        return $FileDecorator;
    }

    /**
     * {@inheritDoc}
     */
    public function normalizeFiles(array $fileInfos): array
    {
        $Files = [];
        foreach ($fileInfos as $index => $fileInfo) {
            if ($fileInfo instanceof FileInterface) {
                $Files[$index] = $fileInfo;
            } else {
                $Files[$index] = $this->normalizeFile($fileInfo);
            }
        }
        return $Files;
    }

    /**
     * UploadedFileInterfaceのあわした配列などを
     * ファイルアップロード仕様に変換するメソッド
     * http://php.net/manual/ja/features.file-upload.post-method.php
     *
     * @param array $fileInfo
     * @return array
     */
    private function satisfyFileSpec(array $fileInfo) : array
    {
        return [
            'tmp_name' => $fileInfo['tmp_name'] ?? $fileInfo['file'],
            'size'     => $fileInfo['size'] ?? null,
            'error'    => $fileInfo['error'] ?? 0,
            'name'     => $fileInfo['name'] ?? $fileInfo['clientFilename'],
            'type'     => $fileInfo['type'] ?? $fileInfo['clientMediaType'],
        ];
    }

    private function getSchema()
    {
        if (null === $this->schema) {
            $config = $this->getConfigManager()->getConfig('file');
            $schema = self::DEFAULT_SCHEMA;
            if (isset($config['schema'])) {
                $schema = array_merge($schema, $config['schema']);
            }
            $this->schema = $schema;
        }
        return $this->schema;
    }
}
