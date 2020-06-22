<?php
declare(strict_types=1);
namespace Std\RouterManager;

use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->export([
    RouterManagerInterface::class => RouterManager::class,
]);
