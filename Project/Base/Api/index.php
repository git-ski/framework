<?php

namespace Project\Base\Api;

use Framework\ObjectManager\ObjectManager;
use Project\Base\Api\EventListenerManager;

$ObjectManager = ObjectManager::getSingleton();
$ObjectManager->get(EventListenerManager::class)->initListener();
