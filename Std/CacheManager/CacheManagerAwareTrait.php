<?php
/**
 * PHP version 7
 * File CacheManagerAwareTrait.php
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
 * Trait CacheManagerAwareTrait
 *
 * @category Trait
 * @package  Std
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait CacheManagerAwareTrait
{
    private static $CacheManager;

    /**
     * CacheManagerをセットする
     *
     * @param CacheManager $CacheManager CacheManager
     *
     * @return void
     */
    public function setCacheManager(CacheManager $CacheManager)
    {
        self::$CacheManager = $CacheManager;
    }

    /**
     * CacheManagerを取得する
     *
     * @return CacheManager $CacheManager
     */
    public function getCacheManager() : CacheManager
    {
        return self::$CacheManager;
    }
}
