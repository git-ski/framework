<?php

namespace Project\Customer\Front;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerInterface;

$ObjectManager = ObjectManager::getSingleton();
$ObjectManager->get(ConfigManagerInterface::class)->register(__DIR__ . '/../config/');
