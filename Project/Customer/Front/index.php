<?php

namespace Project\Customer\Front;

use Framework\ObjectManager\ObjectManager;
use Project\Customer\Front\Authentication\EventListenerManager;
use Project\Customer\Front\EventListenerManager as MypageEventListenerManager;

$ObjectManager = ObjectManager::getSingleton();
$ObjectManager->get(EventListenerManager::class)->initListener();
$ObjectManager->get(MypageEventListenerManager::class)->initListener();
