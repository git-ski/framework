<?php
/**
 * PHP version 7
 * File MessageInterface.php
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
 * Interface MessageInterface
 *
 * とりあえず、基本属性を持つメッセージインターフェース
 *
 * 参考サイト：https://swiftmailer.symfony.com/docs/messages.html#the-structure-of-a-message
 *
 * HEADER                        ACCESSORS
 * Message-ID                   getMessageId()
 * Return-Path                  getReturnPath()
 * From                         getFrom()
 * Sender                       getSender()
 * To                           getTo()
 * Cc                           getCc()
 * Bcc                          getBcc()
 * Reply-To                     getReplyTo()
 * Subject                      getSubject()
 * Date                         getDate()
 * Charset                      getCharset
 * Content-Type                 getContentType()
 * Content-Transfer-Encoding    getEncoding()
 * Attachments                  getAttachments()
 * @category Interface
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface MessageInterface
{
    /**
     * メールのIDを取得する
     *
     * @return string
     */
    public function getMessageId();

    /**
     *
     *
     * @return string
     */
    public function getReturnPath();

    /**
     * FROM（差出人）を取得する
     *
     * @return array
     */
    public function getFrom();

    /**
     * Sender(送信者)を取得する
     *
     * @return array
     */
    public function getSender();

    /**
     * TO（宛先）を取得する
     *
     * @return array
     */
    public function getTo();

    /**
     * Cc:を取得する
     *
     * @return array
     */
    public function getCc();

    /**
     * Bcc:を取得する
     *
     * @return array
     */
    public function getBcc();

    /**
     * ReplyTo（返信先）を取得する
     *
     * @return array
     */
    public function getReplyTo();

    /**
     * 件名を取得する
     *
     * @return string
     */
    public function getSubject();

    /**
     * メール本文を取得する
     *
     * getBodyがtextかhtmlのキーを持つ配列を返すべき
     *
     * [
     *     'text' => '....',
     *     'html' => '.....'
     * ]
     * @return array
     */
    public function getBody();

    /**
     * Method getCharset
     *
     * @return string
     */
    public function getCharset();

    /**
     * Method getContentType
     *
     * @return string
     */
    public function getContentType();

    /**
     * エンコーディングを取得する
     *
     * @return string
     */
    public function getEncoding();

    /**
     * 添付ファイルを取得する
     *
     * @return array
     */
    public function getAttachments();

    /**
     * HTMLテンプレートを取得する
     *
     * @return string
     */
    public function getHtmlTemplate();

    /**
     * 定型文を取得する
     *
     * @return string
     */
    public function getTextTemplate();

    /**
     * メッセージを送信する
     *
     * @return void
     */
    public function send();
}
