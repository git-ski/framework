<?php
namespace Project\AdminUser\Api;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'rest/v1/admin' => Controller\AdminController::class,
      ]);
