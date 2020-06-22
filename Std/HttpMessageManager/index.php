<?php
declare(strict_types=1);
namespace Std\HttpMessageManager;

use Framework\ObjectManager\ObjectManager;
use Std\HttpMessageManager\EventListenerManager;

ObjectManager::getSingleton()->get(EventListenerManager::class)->initListener();
