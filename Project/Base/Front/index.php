<?php

namespace Project\Base\Front;

use Framework\ObjectManager\ObjectManager;
use Project\Base\Front\EventListenerManager;

$ObjectManager = ObjectManager::getSingleton();
$ObjectManager->get(EventListenerManager::class)->initListener();
