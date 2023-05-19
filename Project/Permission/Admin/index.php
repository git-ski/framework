<?php

namespace Project\Permission\Admin;

use Framework\ObjectManager\ObjectManager;
use Project\Permission\Admin\EventListenerManager;

$ObjectManager = ObjectManager::getSingleton();
$ObjectManager->get(EventListenerManager::class)->initListener();
