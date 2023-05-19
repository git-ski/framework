<?php
declare(strict_types=1);
namespace Project\History\Front;

use Framework\ObjectManager\ObjectManager;
use Project\History\Front\EventListenerManager;

ObjectManager::getSingleton()->get(EventListenerManager::class)->initListener();
