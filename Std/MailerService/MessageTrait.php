<?php
/**
 * PHP version 7
 * File FormViewModel.php
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
 * Trait MessageTrait
 *
 * @category Trait
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait MessageTrait
{
    protected $messageId;
    protected $returnPath;
    protected $from     = [];
    protected $sender   = [];
    protected $to       = [];
    protected $cc       = [];
    protected $bcc      = [];
    protected $replyTo  = [];
    protected $subject;
    protected $charset;
    protected $contentType;
    protected $encoding;
    protected $attachments = [];
    protected $body        = [];

    /**
     * メールのIDを取得する
     *
     * @return string
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * Method getReturnPath
     *
     * @return string
     */
    public function getReturnPath()
    {
        return $this->returnPath;
    }

    /**
     * FROM（差出人）を取得する
     *
     * @return array
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Sender(送信者)を取得する
     *
     * @return array
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     *TO（宛先）を取得する
     *
     * @return array
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Cc:を取得する
     *
     * @return array
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Bcc:を取得する
     *
     * @return array
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * 返信を取得する
     *
     * @return array
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * 件名を取得する
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Method getCharset
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Method getContentType
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * エンコーディングを取得する
     *
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * メール本文を取得する
     *
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * 添付ファイルを取得する
     *
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * HTMLテンプレートをセットする
     *
     * @return void
     */
    public function setMessageId($MessageId)
    {
        $this->messageId = $MessageId;
    }

    /**
     * 返信パスをセットする
     *
     * @return void
     */
    public function setReturnPath($ReturnPath)
    {
        $this->returnPath = $ReturnPath;
    }

    /**
     * FROM（差出人）をセットする
     *
     * @return void
     */
    public function setFrom($From)
    {
        $this->from = $From;
    }

    /**
     * Sender（送信者）をセットする
     *
     * @return void
     */
    public function setSender($Sender)
    {
        $this->sender = $Sender;
    }

    /**
     * TO（宛先）をセットする
     *
     * @return void
     */
    public function setTo($To)
    {
        $this->to = $To;
    }

    /**
     * Cc:をセットする
     *
     * @return void
     */
    public function setCc($Cc)
    {
        $this->cc = $Cc;
    }

    /**
     * Bcc:をセットする
     *
     * @return void
     */
    public function setBcc($Bcc)
    {
        $this->bcc = $Bcc;
    }

    /**
     * ReplyTo（返信先）をセットする
     *
     * @return void
     */
    public function setReplyTo($ReplyTo)
    {
        $this->replyTo = $ReplyTo;
    }

    /**
     * 件名をセットする
     *
     * @return void
     */
    public function setSubject($Subject)
    {
        $this->subject = $Subject;
    }

    /**
     * Method setContentType
     *
     * @return void
     */
    public function setContentType($ContentType)
    {
        $this->contentType = $ContentType;
    }

    /**
     * Method setCharset
     *
     * @return void
     */
    public function setCharset($Charset)
    {
        $this->charset = $Charset;
    }

    /**
     * エンコーディングをセットする
     *
     * @return void
     */
    public function setEncoding($Encoding)
    {
        $this->encoding = $Encoding;
    }

    /**
     * メール本文をセットする
     *
     * @return void
     */
    public function setBody($Body)
    {
        $this->body = $Body;
    }

    /**
     * 添付ファイルをセットする
     *
     * @return void
     */
    public function setAttachments($Attachments)
    {
        $this->attachments = $Attachments;
    }

    /**
     * FROM（差出人）を追加する
     *
     * @param $From 差出人メールアドレス
     * @return void
     */
    public function addFrom($From)
    {
        $this->from[] = $From;
    }

    /**
     * TO（宛先）を追加する
     *
     * @param $To 宛先メールアドレス
     * @return void
     */
    public function addTo($To)
    {
        $this->to[] = $To;
    }

    /**
     * Cc:を追加する
     *
     * @param $Cc メールアドレス
     * @return void
     */
    public function addCc($Cc)
    {
        $this->cc[] = $Cc;
    }

    /**
     * Bcc:を追加する
     *
     * @param $Bcc Bccメールアドレス
     * @return void
     */
    public function addBcc($Bcc)
    {
        $this->bcc[] = $Bcc;
    }

    /**
     * 返信先メールアドレスを追加する
     *
     * @param $ReplyTo 返信先メールアドレス
     * @return void
     */
    public function addReplyTo($ReplyTo)
    {
        $this->replyTo[] = $ReplyTo;
    }

    /**
     * 添付ファイルを追加する
     *
     * @return void
     */
    public function addAttachments(AttachmentInterface $Attachments)
    {
        $this->attachments[] = $Attachments;
    }
}
