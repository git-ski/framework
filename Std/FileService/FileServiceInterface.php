<?php
/**
 * PHP version 7
 * File FileServiceInterface.php
 *
 * @category FileService
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\FileService;

use Std\FileService\FileInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\UnreadableFileException;

/**
 * Interface FileService
 *
 * @category Interface
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface FileServiceInterface
{
    /**
     * FileSystemオブジェクトを取得する
     *
     * @return FilesystemInterface
     */
    public function getFileSystem() : FilesystemInterface;

    /**
     * コンテンツを対象ファイルに保存する
     *
     * @param string $relativePath              保存先(相対パス)
     * @param string|StreamInterface $content   保存するコンテンツ
     * @throws UnreadableFileException 保存失敗時
     * @return void
     */
    public function dumpFile(string $relativePath, $content);

    /**
     * 対象ファイルにコンテンツを追加する
     *
     * @param string $relativePath              保存先(相対パス)
     * @param string|StreamInterface $content   追加するコンテンツ
     * @throws UnreadableFileException 保存失敗時
     * @return void
     */
    public function appendToFile(string $relativePath, $content);

    /**
     * 相対パスからファイルコンテンツを取得
     *
     * @param string $relativePath              取得先(相対パス)
     * @throws FileNotFoundException 取得先存在しない場合
     * @return string
     */
    public function load(string $relativePath) : string;

    /**
     * 相対パスからファイルコンテンツを取得
     *
     * @param string $source                    コピーソース(相対パス)
     * @param string $destination               コピー先(相対パス)
     * @throws FileNotFoundException コピーソースファイル存在しない場合
     * @throws UnreadableFileException  コピー失敗時
     * @return void
     */
    public function copy(string $source, string $destination);

    /**
     * ファイル群を削除する
     *
     * @param array $files ファイルパス
     * @return void
     */
    public function remove($files);
    /**
     * アップロードされたファイルを移動する
     * HttpMessageに準拠するUploadedFileをパラメータとして受け取る
     *
     * @param UploadedFileInterface $UploadedFile   アップロードされたファイル
     * @return string                      保存先パス(相対パス)
     * @throws UnreadableFileException      保存失敗時
     * @throws InvalidArgumentException     アップロードファイルでない場合
     */
    public function moveUploadedFile(UploadedFileInterface $UploadedFile) : string;

    /**
     * ファイルパスバリデーション
     * 受け取るパスは、相対パス、あるいは絶対パスとなる。
     * バリデーション完了後、最終的に絶対パスを戻る
     * ※このメソッドの処理では、ファイルパスが有効なる、のみを判断している。
     * ※実際ファイル存在するかどかのチェックを行わない。
     *
     * @param  string $relativeOrAbsolutePath
     * @return string $absolutePath        受取った相対パスから変換した絶対パス
     * @throws InvalidArgumentException    有効なパスでない場合
     */
    public function validateFilePath(string $relativeOrAbsolutePath) : string;

    /**
     * アップロードされたファイル配列をUploadedFileInterfaceのオブジェクトにマッピングする
     * 複数のファイルをマッピングする場合は、
     * Std\FileService\FileServiceInterface::normalizeFiles($files)
     * を使う
     *
     * @param array $fileInfo
     * @return FileInterface
     * @throws InvalidArgumentException   ファイル変換失敗する場合（アップロード失敗など）
     */
    public function normalizeFile(array $fileInfo): FileInterface;

    /**
     * 複数のファイル配列をUploadedFileInterfaceのオブジェクトにマッピングする
     *
     * @param array $fileInfos
     * @return array
     * @throws InvalidArgumentException   ファイル変換失敗する場合（アップロード失敗など）
     */
    public function normalizeFiles(array $fileInfos): array;
}
