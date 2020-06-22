<?php
/**
 * PHP version 7
 * File SingletonTrait.php
 *
 * @category Trait
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Framework\ObjectManager;

/**
 * Trait SingletonTrait
 *
 * @category Trait
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait SingletonTrait
{
    private static $instances = null;

    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
    }

    /**
     * Method getSingleton
     *
     * @return $this
     */
    public static function getSingleton()
    {
        $className = static::class;
        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new $className;
            if (!self::$instances[$className] instanceof ObjectManager) {
                ObjectManager::getSingleton()->injectDependency(self::$instances[$className]);
            }
        }
        return self::$instances[$className];
    }
}
