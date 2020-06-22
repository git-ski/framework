<?php
/**
 * PHP version 7
 * File HttpMessageManagerAwareInterface.php
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
 * Interface HttpMessageManagerAwareInterface
 *
 * @category Interface
 * @package  Std\HttpMessageManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface HttpMessageManagerAwareInterface
{
    /**
     * HttpMessageManagerをセットする
     *
     * @param HttpMessageManagerInterface $HttpMessageManager HttpMessageManager
     * @return mixed
     */
    public function setHttpMessageManager(HttpMessageManagerInterface $HttpMessageManager);

    /**
     * HttpMessageManagerを取得する
     *
     * @return HttpMessageManagerInterface $HttpMessageManager
     */
    public function getHttpMessageManager() : HttpMessageManagerInterface;
}
