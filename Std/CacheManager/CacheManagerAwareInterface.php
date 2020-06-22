<?php
/**
 * PHP version 7
 * File CacheManagerAwareInterface.php
 *
 * @category Service
 * @package  Std
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\CacheManager;

/**
 * Interface CacheManagerAwareInterface
 *
 * @category Interface
 * @package  Std
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface CacheManagerAwareInterface
{
    /**
     * CacheManagerをセットする
     *
     * @param CacheManager $CacheManager CacheManager
     *
     * @return mixed
     */
    public function setCacheManager(CacheManager $CacheManager);

    /**
     * CacheManagerを取得する
     *
     * @return CacheManager $CacheManager
     */
    public function getCacheManager() : CacheManager;
}
