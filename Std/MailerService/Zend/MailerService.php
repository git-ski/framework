<?php
/**
 * PHP version 7
 * File MailerService.php
 *
 * @category Module
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\MailerService\Zend;

use Std\MailerService\MailerServiceInterface;
use Std\MailerService\MessageInterface;
use Framework\ObjectManager\SingletonInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Laminas\Mail\Transport\Smtp;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Mail\Message as MailMessage;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Mime;
use Laminas\Mime\Part as MimePart;
use Laminas\Mail\Header\ContentType as ContentTypeHeader;

/**
 * class MailerService
 * このMailerServiceは、内部にMessageInterfaceをZendのMessageに変換して,
 * ZendのSmtpTransportに渡してメールを送信している。
 *
 * @category Interface
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class MailerService implements
    MailerServiceInterface,
    SingletonInterface,
    ConfigManagerAwareInterface
{
    use \Framework\ObjectManager\SingletonTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    private $transport;
    /**
     * Method send
     *
     * @param MessageInterface $Message
     * @return void
     */
    public function send(MessageInterface $Message)
    {
        $MailMessage = $this->convertMessage($Message);
        assert(
            $MailMessage instanceof MailMessage,
            '無効なMailMessage, Message <-> MailMessageの相互変換が失敗しました'
        );
        $this->getTransport()->send($MailMessage);
    }

    private function getTransport()
    {
        if ($this->transport === null) {
            $config    = $this->getConfigManager()->getConfig('mailer');
            $transport = new Smtp();
            $options   = new SmtpOptions($config['zend-mail']['smtp_options']);
            $transport->setOptions($options);
            $this->transport = $transport;
        }
        return $this->transport;
    }

    /**
     * フレームワークのメッセージをLaminas\Mail\Messageに変換する
     *
     * @param MessageInterface $Message
     * @return MailMessage
     */
    public function convertMessage(MessageInterface $Message) : MailMessage
    {
        $config = $this->getConfigManager()->getConfig('mailer');
        $MailMessage = new MailMessage();
        $charSet = $Message->getCharset() ?? self::JANPANESE_CHARSET;
        if ($Message->getCharset()) {
            $MailMessage->setEncoding($Message->getCharset());
        } else {
            $MailMessage->setEncoding(self::JANPANESE_CHARSET);
        }
        if ($Message->getFrom()) {
            $MailMessage->setFrom($this->convertEncoding($Message->getFrom(), $charSet));
        } else {
            $MailMessage->setFrom($this->convertEncoding($config['default_from'], $charSet));
        }
        if ($Message->getSender()) {
            $MailMessage->setSender($this->convertEncoding($Message->getSender(), $charSet));
        } else {
            $MailMessage->setSender($config['return_path']);
        }
        $MailMessage->setTo($this->convertEncoding($Message->getTo(), $charSet));
        $MailMessage->setCc($this->convertEncoding($Message->getCc(), $charSet));
        $MailMessage->setBcc($this->convertEncoding($Message->getBcc(), $charSet));
        $MailMessage->setSubject($Message->getSubject());
        if ($Message->getReplyTo()) {
            $MailMessage->setReplyTo($this->convertEncoding($Message->getReplyTo(), $charSet));
        } else {
            $MailMessage->setReplyTo($config['default_replyto']);
        }
        // 以下、変換する際にフォーマットする属性
        if ($Message->getMessageId()) {
            $MailMessage->getHeaders()->addHeaderLine('Message-Id', $Message->getMessageId());
        }
        $this->convertBody($MailMessage, $Message);
        return $this->withAttachments($MailMessage, $Message);
    }

    private function convertBody(MailMessage $MailMessage, MessageInterface $Message)
    {
        // Text/Html対応
        $body = $this->makeMultipartBody($Message);
        $MailMessage->setBody($body);
        // 最初にbodyを変換する
        // content-typeを設定後にbodyを変換すると、content-typeが上書きされる
        // zendのドキュメントに参照する。
        // https://docs.zendframework.com/zend-mail/message/attachments/#multipartalternative-content
        $Headers           = $MailMessage->getHeaders();
        $ContentTypeHeader = $Headers->get('Content-Type');
        assert($ContentTypeHeader instanceof ContentTypeHeader);
        if ($Message->getContentType()) {
            $ContentTypeHeader->setType($Message->getContentType());
        } else {
            if ($body->isMultiPart()) {
                $ContentTypeHeader->setType(Mime::MULTIPART_ALTERNATIVE);
            }
        }
    }

    private function makeMultipartBody(MessageInterface $Message) : MimeMessage
    {
        $body = $Message->getBody();
        $parts = [];
        $charSet = $Message->getCharset() ?? self::JANPANESE_CHARSET;
        if (isset($body['text'])) {
            $content = $this->convertEncoding($body['text'], $charSet);
            $part = new MimePart($content);
            $part->type = Mime::TYPE_TEXT;
            $this->configurePart($part, $Message);
            $parts[] = $part;
        }
        if (isset($body['html'])) {
            $content = $this->convertEncoding($body['html'], $charSet);
            $part = new MimePart($content);
            $part->type = Mime::TYPE_HTML;
            $this->configurePart($part, $Message);
            $parts[] = $part;
        }
        $mimeBody = new MimeMessage();
        $mimeBody->setParts($parts);
        return $mimeBody;
    }

    /**
     *
     *
     * @param MimePart $Part
     * @param MessageInterface $Message
     * @return void
     */
    private function configurePart(MimePart $Part, MessageInterface $Message)
    {
        if ($Message->getCharset()) {
            $Part->charset = $Message->getCharset();
        } else {
            $Part->charset = self::JANPANESE_CHARSET;
        }
        if ($Message->getEncoding()) {
            $Part->encoding = $Message->getEncoding();
        } else {
            $Part->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
        }
    }

    /**
     * メールにファイルを添付する
     *
     * @param MailMessage $MailMessage
     * @param MessageInterface $Message
     * @return MailMessage
     */
    private function withAttachments(MailMessage $MailMessage, MessageInterface $Message)
    {
        if (!$Message->getAttachments()) {
            return $MailMessage;
        }
        $alternatives = $MailMessage->getBody();
        if (count($alternatives->getParts()) > 1) {
            $alternativesPart = new MimePart($alternatives->generateMessage());
            $alternativesPart->type = "multipart/alternative;\n boundary=\"" . $alternatives->getMime()->boundary() . "\"";
            $body = new MimeMessage();
            $body->addPart($alternativesPart);
        } else {
            $body = $alternatives;
        }
        $charSet = $Message->getCharset() ?? self::JANPANESE_CHARSET;
        foreach ($Message->getAttachments() as $Attachment) {
            $part           = new MimePart(fopen($Attachment->getPath(), 'r'));
            $part->type     = Mime::TYPE_OCTETSTREAM;

            $filename       = $this->convertEncoding($Attachment->getFileName(), $charSet);
            $filename       = ' filename*=' . $charSet . '\'' . $filename . ';';
            $part->disposition = Mime::DISPOSITION_ATTACHMENT . '; ' . $filename;
            if ($Attachment->getEncoding()) {
                $part->encoding = $Attachment->getEncoding();
            } else {
                $part->encoding = Mime::ENCODING_BASE64;
            }
            $body->addPart($part);
        }
        // 添付ファイルを追加するために、Bodyを作り直す
        $MailMessage->setBody($body);
        // body変換時と同じ、最後でContent-typeを設定する。
        $ContentTypeHeader = $MailMessage->getHeaders()->get('Content-Type');
        assert($ContentTypeHeader instanceof ContentTypeHeader);
        $ContentTypeHeader->setType(Mime::MULTIPART_RELATED);
        return $MailMessage;
    }

    /**
     * 日本語エンコードに変換する
     *
     * @param  string|array $stringOrArray
     * @return string|array $stringOrArray
     */
    private function convertEncoding($stringOrArray, $toChartset = self::JANPANESE_CHARSET)
    {
        if (is_array($stringOrArray)) {
            foreach ($stringOrArray as $key => $value) {
                $stringOrArray[$key] = $this->convertEncoding($value, $toChartset);
            }
        } else {
            $stringOrArray = mb_convert_encoding($stringOrArray, $toChartset, self::BASIC_CHARSET);
        }
        return $stringOrArray;
    }
}
