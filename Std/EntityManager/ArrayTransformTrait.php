<?php
/**
 * PHP version 7
 * File ArrayTransformTrait.php
 *
 * @category Trait
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\EntityManager;

use Framework\ObjectManager\ObjectManager;
use Std\CacheManager\CacheManagerInterface;

/**
 * Trait ArrayTransformTrait
 *
 * @category Trait
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait ArrayTransformTrait
{
    private static $objectKey    = [];
    private static $objectSetter = [];

    /**
     * オブジェクトをArrayに変換
     *
     * @return array
     */
    public function toArray() : array
    {
        $modelArray = array_values((array) $this);
        $objectKey = $this->getObjectKey();
        return array_combine($objectKey, $modelArray);
    }

    /**
     * Arrayをオブジェクトにマッピングする
     *
     * @param array $data
     * @return void
     */
    public function fromArray(array $data)
    {
        $objectSetter = $this->getObjectSetter();
        foreach ($objectSetter as $key => $setter) {
            if (isset($data[$key])) {
                call_user_func([$this, $setter], $data[$key]);
            }
        }
    }

    /**
     * Entityごとに、キー配列を取得
     * 手動JIT
     */
    private function getObjectKey()
    {
        if (!isset(self::$objectKey[static::class])) {
            $tmp = array_keys((array) $this);
            $objectKey    = [];
            array_walk($tmp, function ($item) use (&$objectKey) {
                $key            = str_replace([static::class, get_parent_class(static::class), self::class], '', $item);
                $key            = trim($key);
                $objectKey[]    = $key;
            });
            self::$objectKey[static::class]     = $objectKey;
        }
        return self::$objectKey[static::class];
    }

    /**
     * Entityごとに、キーセッター配列を取得
     * 手動JIT
     */
    private function getObjectSetter()
    {
        if (!isset(self::$objectSetter[static::class])) {
            $objectKey = $this->getObjectKey();
            foreach ($objectKey as $key) {
                $setter = 'set' . ucfirst($key);
                if (is_callable([$this, $setter])) {
                    $objectSetter[$key] = $setter;
                }
            }
            self::$objectSetter[static::class]  = $objectSetter;
        }
        return self::$objectSetter[static::class];
    }
}
