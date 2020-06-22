<?php
/**
 * PHP version 7
 * File AttachmentInterface.php
 *
 * @category Module
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\MailerService;

/**
 * Interface AttachmentInterface
 *
 * 基本属性を持つ添付ファイルインターフェース
 *
 * 参考サイト：https://zendframework.github.io/zend-mime/part/#available-methods
 *
 * @category Interface
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface AttachmentInterface
{
    /**
     * ファイルのパスを取得する
     *
     * @return void
     */
    public function getPath();

    /**
     * MIMEタイプを取得する
     *
     * @return void
     */
    public function getMimeType();

    /**
     * ファイル名を取得する
     *
     * @return void
     */
    public function getFileName();

    /**
     * dispositionを取得する
     *
     * @return void
     */
    public function getDisposition();

    /**
     * エンコーディングを取得する
     *
     * @return void
     */
    public function getEncoding();
}
