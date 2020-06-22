<?php
namespace Project\Base\Front;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        '[locale]'           => Controller\Front\TopController::class,
        '[locale/]forbidden' => Controller\ForbiddenController::class,
        '[locale/]not_found' => Controller\NotFoundController::class,
        '[locale/]error'     => Controller\ServerErrorController::class,
    ]);
