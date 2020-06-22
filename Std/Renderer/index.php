<?php
declare(strict_types=1);
namespace Std\Renderer;

use Framework\ObjectManager\ObjectManager;
use Std\Renderer\EventListenerManager;

ObjectManager::getSingleton()->get(EventListenerManager::class)->initListener();
