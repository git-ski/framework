<?php
/**
 * PHP version 7
 * File Attachment.php
 *
 * @category Module
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\MailerService;

use Std\MailerService\AttachmentInterface;
/**
 * Class Attachment
 *
 * 基本属性を持つ添付ファイルインターフェースを実装した添付ファイルオブジェクト
 *
 * @category Class
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Attachment implements AttachmentInterface
{
    private $path;
    private $mimeType;
    private $fileName;
    private $disposition;
    private $encoding;

    /**
     * ファイルのパスを取得する
     *
     * @return void
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * MIMEタイプを取得する
     *
     * @return void
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * ファイル名を取得する
     *
     * @return void
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * dispositionを取得する
     *
     * @return void
     */
    public function getDisposition()
    {
        return $this->disposition;
    }

    /**
     * エンコーディングを取得する
     *
     * @return void
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * ファイルのパスをセットする
     *
     * @param string $Path
     * @return void
     */
    public function setPath($Path)
    {
        $this->path = $Path;
    }

    /**
     * MIMEタイプをセットする
     *
     * @param string $MimeType
     * @return void
     */
    public function setMimeType($MimeType)
    {
        $this->mimeType = $MimeType;
    }

    /**
     * ファイル名をセットする
     *
     * @param string $FileName
     * @return void
     */
    public function setFileName($FileName)
    {
        $this->fileName = $FileName;
    }

    /**
     * dispositionをセットする
     *
     * @param string $Disposition
     * @return void
     */
    public function setDisposition($Disposition)
    {
        $this->disposition = $Disposition;
    }

    /**
     * エンコーディングをセットする
     *
     * @param string $Encoding
     * @return void
     */
    public function setEncoding($Encoding)
    {
        $this->encoding = $Encoding;
    }
}
