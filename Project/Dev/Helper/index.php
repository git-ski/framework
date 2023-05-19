<?php

namespace Project\Dev\Helper;

use Framework\ObjectManager\ObjectManager;
use Project\Dev\Helper\EventListenerManager;

$ObjectManager = ObjectManager::getSingleton();
$ObjectManager->get(EventListenerManager::class)->initListener();
