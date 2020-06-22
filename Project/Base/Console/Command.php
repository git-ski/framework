<?php
declare(strict_types=1);
namespace Project\Base\Console;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'cache:clear:all' => Controller\Cache\CacheClearController::class,
        'cache:warmup' => Controller\Cache\WarmupController::class,
        'route:list' => Controller\Route\ListController::class,
        'event:list' => Controller\Event\ListController::class,
        'entity:list' => Controller\Entity\ListController::class,
        'list' => Controller\ListController::class,
        'help' => Controller\HelpController::class,
    ]);
