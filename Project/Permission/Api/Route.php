<?php
namespace Project\Permission\Api;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'rest/v1/role' => Controller\RoleController::class,
      ]);
