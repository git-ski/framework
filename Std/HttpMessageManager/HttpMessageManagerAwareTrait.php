<?php
/**
 * PHP version 7
 * File HttpMessageManagerAwareTrait.php
 *
 * @category HttpMessageManager
 * @package  Std\HttpMessageManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\HttpMessageManager;

use Std\HttpMessageManager\HttpMessageManagerInterface;

/**
 * trait HttpMessageManagerAwareTrait
 *
 * @category Trait
 * @package  Std\HttpMessageManagerAwareTrait
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait HttpMessageManagerAwareTrait
{
    private static $HttpMessageManager;

    /**
     * HttpMessageManagerをセットする
     *
     * @param HttpMessageManagerInterface $HttpMessageManager HttpMessageManager
     * @return $this
     */
    public function setHttpMessageManager(HttpMessageManagerInterface $HttpMessageManager)
    {
        self::$HttpMessageManager = $HttpMessageManager;
        return $this;
    }

    /**
     * HttpMessageManagerを取得する
     *
     * @return HttpMessageManagerInterface $HttpMessageManager
     */
    public function getHttpMessageManager(): HttpMessageManagerInterface
    {
        return self::$HttpMessageManager;
    }
}
