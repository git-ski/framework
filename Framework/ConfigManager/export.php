<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);
namespace Framework\ConfigManager;

use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()
    ->get(ConfigManagerInterface::class, ConfigManager::class)
    // ->useCache(ROOT_DIR . 'var/cache/all.config.php')
    ->register(ROOT_DIR . 'config/');
