<?php
/**
 * PHP version 7
 * File MailerServiceAwareInterface.php
 *
 * @category Router
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\MailerService;

/**
 * Interface MailerServiceAwareInterface
 *
 * @category Interface
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface MailerServiceAwareInterface
{
    /**
     * MailerServiceオブジェクトをセットする
     *
     * @param MailerServiceInterface $MailerService MailerService
     * @return mixed
     */
    public function setMailerService(MailerServiceInterface $MailerService);

    /**
     * MailerServiceオブジェクトを取得する
     *
     * @return MailerServiceInterface $MailerService
     */
    public function getMailerService() : MailerServiceInterface;
}
