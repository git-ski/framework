<?php
declare(strict_types=1);
namespace Std\RouterManager;

use Framework\ObjectManager\ObjectManager;
use Std\RouterManager\EventListenerManager;

ObjectManager::getSingleton()->get(EventListenerManager::class)->initListener();
