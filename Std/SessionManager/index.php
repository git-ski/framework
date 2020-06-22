<?php
declare(strict_types=1);
namespace Std\SessionManager;

use Framework\ObjectManager\ObjectManager;
use Std\SessionManager\EventListenerManager;

ObjectManager::getSingleton()->get(EventListenerManager::class)->initListener();
