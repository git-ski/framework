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

namespace Std\MailerService\Symfony;

use Std\MailerService\MailerServiceInterface;
use Std\MailerService\MessageInterface;
use Framework\ObjectManager\SingletonInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Address;

/**
 * class MailerService
 * このMailerServiceは、内部にMessageInterfaceをSymfonyのSymfonyMessageに変換して,
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
        // Symfony::init(function () {
        //     Symfony_DependencyContainer::getInstance()
        //         ->register('mime.qpheaderencoder')
        //         ->asAliasOf('mime.base64headerencoder');

        //     Symfony_Preferences::getInstance()->setCharset('iso-2022-jp');
        // });
        $SymfonyMessage = $this->convertMessage($Message);
        assert(
            $SymfonyMessage instanceof Email,
            '無効なEmail, Message <-> Emailの相互変換が失敗しました'
        );

        $this->getMailer()->send($SymfonyMessage);
    }

    private function getMailer()
    {
        if ($this->mailer === null) {
            $config    = $this->getConfigManager()->getConfig('mailer.adapter.symfony');

            $transport = Transport::fromDsn("smtp://{$config['host']}:{$config['port']}");

            if (isset($config['user']) && isset($config['pass'])) {
                $transport->setUsername($config['user']);
                $transport->setPassword($config['pass']);
            }
            $this->mailer = new Mailer($transport);
        }
        return $this->mailer;
    }

    /**
     * フレームワークのメッセージをLaminas\Mail\Messageに変換する
     *
     * @param MessageInterface $Message
     * @return SymfonyMessage
     */
    public function convertMessage(MessageInterface $Message) : Email
    {
        $config = $this->getConfigManager()->getConfig('mailer');
        $SymfonyMessage = new Email();

        $headers = new Headers();
        // $headers->addTextHeader('Content-Type', 'text/plain; charset=iso-2022-jp');
        $headers->addParameterizedHeader('Content-Transfer-Encoding', 'quoted-printable');
        $SymfonyMessage->setHeaders($headers);

        // if ($Message->getCharset()) {
        //     $SymfonyMessage->setCharset($Message->getCharset());
        // } else {
        //     $SymfonyMessage->setCharset(self::JANPANESE_CHARSET);
        // }

        if ($Message->getFrom()) {
            $SymfonyMessage->from($Message->getFrom());
        } else {
            $SymfonyMessage->from($config['default_from']);
        }

        if ($Message->getSender()) {
            $SymfonyMessage->sender($Message->getSender());
        } else {
            $SymfonyMessage->sender($config['return_path']);
        }
        foreach($Message->getTo() as $address => $name) {
            $SymfonyMessage->to(new Address($address, $name));
        }
        foreach($Message->getCc() as $address => $name) {
            $SymfonyMessage->cc(new Address($address, $name));
        }
        foreach($Message->getBcc() as $address => $name) {
            $SymfonyMessage->bcc(new Address($address, $name));
        }
        $SymfonyMessage->subject($Message->getSubject());
        if ($Message->getReplyTo()) {
            $SymfonyMessage->replyTo($Message->getReplyTo());
        } else {
            $SymfonyMessage->replyTo($config['default_replyto']);
        }
        // 以下、変換する際にフォーマットする属性
        $this->convertBody($SymfonyMessage, $Message);
        // 最初にbodyを変換する
        return $this->withAttachments($SymfonyMessage, $Message);
    }

    private function convertBody(Email $SymfonyMessage, MessageInterface $Message)
    {
        $body = $Message->getBody();
        if (isset($body['text'])) {
            $SymfonyMessage->text($body['text']);
        }
        if (isset($body['html'])) {
            $SymfonyMessage->html($body['html']);
        }
    }


    private function withAttachments(Email $SymfonyMessage, MessageInterface $Message)
    {
        if (!$Message->getAttachments()) {
            return $SymfonyMessage;
        }
        foreach ($Message->getAttachments() as $Attachment) {
            $SymfonyMessage->addPart(new DataPart(new File($Attachment->getPath()), $Attachment->getFileName()));
        }
        return $SymfonyMessage;
    }
}
