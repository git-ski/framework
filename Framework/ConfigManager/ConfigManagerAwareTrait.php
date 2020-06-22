<?php
/**
 * PHP version 7
 * File ConfigManagerAwareTrait.php
 *
 * @category ConfigManager
 * @package  Framework\ConfigManagerManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\ConfigManager;

/**
 * Trait ConfigManagerAwareTrait
 *
 * @category Trait
 * @package  Framework\ConfigManagerManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait ConfigManagerAwareTrait
{
    private static $ConfigManager;

    /**
     * Method setConfigManager
     *
     * @param ConfigManagerInterface $ConfigManager ConfigManager
     * @return $this
     */
    public function setConfigManager(ConfigManagerInterface $ConfigManager)
    {
        self::$ConfigManager = $ConfigManager;
        return $this;
    }

    /**
     * Method getConfigManager
     *
     * @return ConfigManagerInterface $ConfigManager
     */
    public function getConfigManager() : ConfigManagerInterface
    {
        return self::$ConfigManager;
    }
}
