<?php
/**
 * PHP version 7
 * File CacheManager.php
 *
 * @category Service
 * @package  Std
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\CacheManager;

use Framework\ObjectManager\SingletonInterface;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Laminas\Cache\Storage\FlushableInterface;
use Laminas\Cache\Storage\StorageInterface;

/**
 * Interface CacheManager
 *
 * @category Interface
 * @package  Std
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class CacheManager implements
    CacheManagerInterface,
    SingletonInterface,
    ConfigManagerAwareInterface,
    ObjectManagerAwareInterface
{
    use \Framework\ObjectManager\SingletonTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Framework\ObjectManager\ObjectManagerAwareTrait;

    private $cachePool = [];

    /**
     * キャッシュを登録する
     *
     * @param string                                      $section        cacheSection
     * @param StorageInterface|array   $cacheOrOptions cacheStorageOrOptions
     *
     * @return $this
     */
    public function setCache($section, $cacheOrOptions)
    {
        if (!$cacheOrOptions instanceof StorageInterface) {
            $cacheOrOptions  = new \Laminas\Cache\Storage\Adapter\Memory();
        }
        $this->cachePool[$section] = $cacheOrOptions;
        return $this;
    }

    /**
     * キャッシュを取得する
     * 利用側はキャッシュの実体(memcachedかmemoryかredisなど)を意識しなくても取得するように
     * 特別の理由がなければ、optionsを指定しない
     *
     * @param string    $section cacheSection
     * @param array     $options cacheOptions
     * @return StorageInterface
     */
    public function getCache($section, $options = null) : StorageInterface
    {
        if (isset($this->cachePool[$section])) {
            return $this->cachePool[$section];
        }
        if (!is_array($options)) {
            $config = $this->getConfigManager()->getConfig('cache');
            if ($options === null || !isset($config['adapter'][$options])) {
                $options = $config['default'];
            }
            $delegateOptions = $config['adapter'][$options];
            $delegateOptions['adapter']['options']['namespace'] .= $section;
            $options = $delegateOptions;
        }
        $this->setCache($section, $options);
        return $this->cachePool[$section];
    }

    /**
     * 指定するキャッシュをdetachする
     * 主に、キャッシュクリア機能にてクリアされたくないキャッシュを作成後、detachすると
     * CacheManagerから管理を外れる。
     *
     * @param string $section
     * @return void
     */
    public function detach($section)
    {
        if (isset($this->cachePool[$section])) {
            unset($this->cachePool[$section]);
        }
    }

    /**
     * 全てのキャッシュをクリアする
     * ※Memcachedの場合は、全てのキャッシュを期限切れにする。
     *
     * @return $this
     */
    public function flushAll()
    {
        foreach ($this->cachePool as $Cache) {
            if ($Cache instanceof FlushableInterface) {
                $Cache->flush();
            }
        }
        return $this;
    }
}
