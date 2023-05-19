<?php
declare(strict_types=1);
namespace Project\History\Admin;

use Framework\ObjectManager\ObjectManager;
use Project\History\Admin\EventListenerManager;

ObjectManager::getSingleton()->get(EventListenerManager::class)->initListener();
