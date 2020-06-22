<?php
/**
 * PHP version 7
 * File MailerServiceAwareTrait.php
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
 * Trait MailerServiceAwareTrait
 *
 * @category Trait
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait MailerServiceAwareTrait
{
    private static $MailerService;

    /**
     * MailerServiceオブジェクトをセットする
     *
     * @param MailerServiceInterface $MailerService MailerService
     * @return $this
     */
    public function setMailerService(MailerServiceInterface $MailerService)
    {
        self::$MailerService = $MailerService;
        return $this;
    }

    /**
     * MailerServiceオブジェクトを取得する
     *
     * @return MailerServiceInterface $MailerService
     */
    public function getMailerService() : MailerServiceInterface
    {
        return self::$MailerService;
    }
}
