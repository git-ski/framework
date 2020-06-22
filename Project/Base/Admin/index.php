<?php

namespace Project\Base\Admin;

use Framework\ObjectManager\ObjectManager;
use Project\Base\Admin\EventListenerManager;

$ObjectManager = ObjectManager::getSingleton();
$ObjectManager->get(EventListenerManager::class)->initListener();
