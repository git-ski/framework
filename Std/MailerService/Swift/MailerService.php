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

namespace Std\MailerService\Swift;

use Std\MailerService\MailerServiceInterface;
use Std\MailerService\MessageInterface;
use Framework\ObjectManager\SingletonInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Swift;
use Swift_DependencyContainer;
use Swift_Preferences;
use Swift_Message;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Encoding;
use Swift_Attachment;

/**
 * class MailerService
 * このMailerServiceは、内部にMessageInterfaceをSymfonyのSwiftMessageに変換して,
 * メールを送信している。
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

    private $mailer;
    /**
     * Method send
     *
     * @param MessageInterface $Message
     * @return void
     */
    public function send(MessageInterface $Message)
    {
        Swift::init(function () {
            Swift_DependencyContainer::getInstance()
                ->register('mime.qpheaderencoder')
                ->asAliasOf('mime.base64headerencoder');

            Swift_Preferences::getInstance()->setCharset('iso-2022-jp');
        });
        $SwiftMessage = $this->convertMessage($Message);
        assert(
            $SwiftMessage instanceof Swift_Message,
            '無効なSwift_Message, Message <-> Swift_Messageの相互変換が失敗しました'
        );
        $this->getMailer()->send($SwiftMessage);
    }

    private function getMailer()
    {
        if ($this->mailer === null) {
            $config    = $this->getConfigManager()->getConfig('mailer')['swift-mail'];

            $transport = new Swift_SmtpTransport($config['host'], $config['port']);
            if (isset($config['user']) && isset($config['pass'])) {
                $transport->setUsername($config['user']);
                $transport->setPassword($config['pass']);
            }
            if (isset($config['encryption'])) {
                $transport->setEncryption($config['encryption']);
            }

            $this->mailer = new Swift_Mailer($transport);
        }
        return $this->mailer;
    }

    /**
     * フレームワークのメッセージをLaminas\Mail\Messageに変換する
     *
     * @param MessageInterface $Message
     * @return SwiftMessage
     */
    public function convertMessage(MessageInterface $Message) : Swift_Message
    {
        $config = $this->getConfigManager()->getConfig('mailer');
        $SwiftMessage = new Swift_Message();
        if ($Message->getCharset()) {
            $SwiftMessage->setCharset($Message->getCharset());
        } else {
            $SwiftMessage->setCharset(self::JANPANESE_CHARSET);
        }

        if ($Message->getFrom()) {
            $SwiftMessage->setFrom($Message->getFrom());
        } else {
            $SwiftMessage->setFrom($config['default_from']);
        }

        if ($Message->getSender()) {
            $SwiftMessage->setSender($Message->getSender());
        } else {
            $SwiftMessage->setSender($config['return_path']);
        }
        $SwiftMessage->setTo($Message->getTo());
        $SwiftMessage->setCc($Message->getCc());
        $SwiftMessage->setBcc($Message->getBcc());
        $SwiftMessage->setSubject($Message->getSubject());
        if ($Message->getReplyTo()) {
            $SwiftMessage->setReplyTo($Message->getReplyTo());
        } else {
            $SwiftMessage->setReplyTo($config['default_replyto']);
        }
        // 以下、変換する際にフォーマットする属性
        if ($Message->getMessageId()) {
            $SwiftMessage->setId($Message->getMessageId());
        }
        $this->convertBody($SwiftMessage, $Message);
        // 最初にbodyを変換する
        return $this->withAttachments($SwiftMessage, $Message);
    }

    private function convertBody(Swift_Message $SwiftMessage, MessageInterface $Message)
    {
        $body = $Message->getBody();
        if (isset($body['text'])) {
            $SwiftMessage->setBody($body['text']);
        }
        if (isset($body['html'])) {
            if (!isset($body['text'])) {
                $SwiftMessage->setBody($body['html'], 'text/html');
            } else {
                $SwiftMessage->addPart($body['html'], 'text/html');
            }
        }
    }


    private function withAttachments(Swift_Message $SwiftMessage, MessageInterface $Message)
    {
        if (!$Message->getAttachments()) {
            return $SwiftMessage;
        }
        foreach ($Message->getAttachments() as $Attachment) {
            $SwiftAttachment = Swift_Attachment::fromPath($Attachment->getPath());
            $SwiftAttachment->setFilename($Attachment->getFileName());
            $SwiftMessage->attach($SwiftAttachment);
        }
        return $SwiftMessage;
    }
}
