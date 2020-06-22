<?php
declare(strict_types=1);
namespace Project\Base\Console;

use Std\Controller\ConsoleInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->export([
    ConsoleInterface::class => Controller\ListController::class
]);
