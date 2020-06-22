<?php

namespace Project\Base\Console;

use Framework\ObjectManager\ObjectManager;
use Project\Base\Console\EventListenerManager;

$ObjectManager = ObjectManager::getSingleton();
$ObjectManager->get(EventListenerManager::class)->initListener();
