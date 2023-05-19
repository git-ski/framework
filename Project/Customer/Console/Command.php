<?php
declare(strict_types=1);
namespace Project\Customer\Console;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'customer:import' => Controller\ImportController::class,
    ]);
