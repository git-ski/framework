<?php
declare(strict_types=1);
namespace Std\HttpMessageManager;

use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->export([
    HttpMessageManagerInterface::class => HttpMessageManager::class,
]);
