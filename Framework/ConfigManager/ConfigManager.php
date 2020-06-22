<?php
/**
 * PHP version 7
 * File AbstractConfigModel.php
 *
 * @category Config
 * @package  Framework\ConfigManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\ConfigManager;

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\Stdlib\Glob;

/**
 * Abstract Class AbstractConfigModel
 *
 * @category Class
 * @package  Framework\ConfigManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class ConfigManager implements ConfigManagerInterface
{
    private $configFolders = [];
    private $aggregator    = null;
    private $cache         = null;

    /**
     * {@inheritDoc}
     */
    public function useCache($cacheFile)
    {
        $this->cache = $cacheFile;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function register($configFolder)
    {
        $this->configFolders[$configFolder] = $configFolder;
        return $this;
    }

    /**
     *{@inheritDoc}
     */
    public function getAggregator() : ConfigAggregator
    {
        if ($this->aggregator === null) {
            $this->aggregator = new ConfigAggregator([
                function () :iterable {
                    foreach ($this->configFolders as $folderPath) {
                        foreach (Glob::glob($folderPath . '/*.config.php', Glob::GLOB_BRACE) as $file) {
                            yield include $file;
                        }
                        foreach (Glob::glob($folderPath . ENVIRONMENT . '/*.config.php', Glob::GLOB_BRACE) as $file) {
                            yield include $file;
                        }
                    }
                    if ($this->cache) {
                        yield [
                            ConfigAggregator::ENABLE_CACHE => true
                        ];
                    }
                }
            ], $this->cache);
        }
        return $this->aggregator;
    }

    /**
     * {@inheritDoc}
     */
    public function getMergedConfig()
    {
        return $this->getAggregator()->getMergedConfig();
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig($name, $default = null)
    {
        return $this->getConfigFromPath($name, $default);
    }

    public function getConfigFromPath($configPath, $default = null, $config = null)
    {
        // 中止条件 1
        if (empty($configPath)) {
            return $config;
        }
        // 中止条件 2
        if ([] === $config) {
            return null;
        }
        // 初期条件配置
        if (is_string($configPath)) {
            $configPath = explode('.', $configPath);
        }
        if (null === $config) {
            $config = $this->getMergedConfig();
        }
        // 設定探し
        $search = array_shift($configPath);
        $config = $config[$search] ?? [];
        return $this->getConfigFromPath($configPath, $default, $config);
    }
}
