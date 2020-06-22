<?php
/**
 * PHP version 7
 * File MailerServiceInterface.php
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
 * Interface MailerServiceInterface
 *
 * @category Interface
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface MailerServiceInterface
{
    const BASIC_CONTENT_TYPE       = 'text/plain';
    const ALTERNATIVE_CONTENT_TYPE = 'multipart/alternative';
    const ATTACHMENT_CONTENT_TYPE  = 'multipart/related';

    const BASIC_ENCODING      = '7bit';
    const ATTACHMENT_ENCODING = 'base64';

    const JANPANESE_CHARSET = 'ISO-2022-JP';
    const BASIC_CHARSET     = 'UTF-8';

    /**
     * メールを送信する
     *
     * @param MessageInterface $Message
     * @return void
     */
    public function send(MessageInterface $Message);
}
