<?php
declare(strict_types=1);
namespace Std\TranslatorManager;

use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->export([
    TranslatorManagerInterface::class => TranslatorManager::class,
]);
