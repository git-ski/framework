<?php
/**
 * PHP version 7
 * File CacheManagerInterface.php
 *
 * @category Service
 * @package  Std
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\CacheManager;

use Laminas\Cache\Storage\StorageInterface;

/**
 * Interface CacheManagerInterface
 *
 * @category Interface
 * @package  Std
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface CacheManagerInterface
{

    /**
     * キャッシュを登録する
     *
     * @param string                                      $section        cacheSection
     * @param StorageInterface|array   $cacheOrOptions cacheStorageOrOptions
     *
     * @return $this
     */
    public function setCache($section, $cacheOrOptions);

    /**
     * キャッシュを取得する
     * 利用側はキャッシュの実体(memcachedかmemoryかredisなど)を意識しなくても取得するように
     * 特別の理由がなければ、optionsを指定しない
     *
     * @param string    $section cacheSection
     * @param array     $options cacheOptions
     * @return StorageInterface
     */
    public function getCache($section, $options = null) : StorageInterface;

    /**
     * 全てのキャッシュをクリアする
     * ※Memcachedの場合は、全てのキャッシュを期限切れにする。
     *
     * @return $this
     */
    public function flushAll();
}
