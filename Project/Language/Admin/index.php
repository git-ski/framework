<?php
declare(strict_types=1);
namespace Project\Language\Admin;

use Framework\ObjectManager\ObjectManager;
use Project\Language\Admin\EventListenerManager;

ObjectManager::getSingleton()->get(EventListenerManager::class)->initListener();
