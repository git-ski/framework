<?php
declare(strict_types=1);
namespace Project\Language\Front;

use Framework\ObjectManager\ObjectManager;
use Project\Language\Front\EventListenerManager;

ObjectManager::getSingleton()->get(EventListenerManager::class)->initListener();
