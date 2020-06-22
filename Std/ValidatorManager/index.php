<?php
declare(strict_types=1);
namespace Std\ValidatorManager;

/**
* @codeCoverageIgnore
*/
use Framework\ObjectManager\ObjectManager;
use Std\ValidatorManager\EventListenerManager;

ObjectManager::getSingleton()->get(EventListenerManager::class)->initListener();
