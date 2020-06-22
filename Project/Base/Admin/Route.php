<?php
// @codingStandardsIgnoreFile
namespace Project\Base\Admin;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'admin' => Controller\DashboardController::class,
        'admin/vocabulary/register' => Controller\Vocabulary\RegisterController::class,
        'admin/vocabulary/list' => Controller\Vocabulary\ListController::class,
        'admin/vocabulary/edit' => Controller\Vocabulary\EditController::class,
        'admin/vocabulary/delete' => Controller\Vocabulary\DeleteController::class,
    ]);
