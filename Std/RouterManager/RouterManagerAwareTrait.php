<?php
/**
 * PHP version 7
 * File RouterManagerAwareTrait.php
 *
 * @category Router
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\RouterManager;

/**
 * Trait RouterManagerAwareTrait
 *
 * @category Trait
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait RouterManagerAwareTrait
{
    private static $RouterManager;

    /**
     * Method setRouterManager
     *
     * @param RouterManagerInterface $RouterManager RouterManager
     * @return $this
     */
    public function setRouterManager(RouterManagerInterface $RouterManager)
    {
        self::$RouterManager = $RouterManager;
        return $this;
    }

    /**
     * Method getRouterManager
     *
     * @return RouterManagerInterface $RouterManager
     */
    public function getRouterManager() : RouterManagerInterface
    {
        return self::$RouterManager;
    }

    public function getRouter()
    {
        if (self::$RouterManager) {
            // マッチしたルータがあれば、そのルータを返す。
            if (self::$RouterManager->getMatched()) {
                return self::$RouterManager->getMatched();
            } else {
                // マッチしたルータがなければ、デフォルトのルータを返す
                self::$RouterManager->get(__NAMESPACE__);
            }
        }
    }
}
