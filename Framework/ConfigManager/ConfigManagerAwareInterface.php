<?php
/**
 * PHP version 7
 * File ConfigManagerAwareInterface.php
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
 * Interface ConfigManagerAwareInterface
 *
 * @category Interface
 * @package  Framework\ConfigManagerManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ConfigManagerAwareInterface
{
    /**
     * Method setConfigManager
     *
     * @param ConfigManagerInterface $ConfigManager ConfigManager
     * @return $this
     */
    public function setConfigManager(ConfigManagerInterface $ConfigManager);

    /**
     * Method getConfigManager
     *
     * @return ConfigManagerInterface $ConfigManager
     */
    public function getConfigManager() : ConfigManagerInterface;
}
