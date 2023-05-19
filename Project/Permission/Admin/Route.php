<?php
namespace Project\Permission\Admin;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'admin/role/register' => Controller\Role\RegisterController::class,
        'admin/role/list' => Controller\Role\ListController::class,
        'admin/role/edit' => Controller\Role\EditController::class,
        'admin/role/delete' => Controller\Role\DeleteController::class,
        'admin/permission/configuration' => Controller\Permission\ConfigurationController::class,
      ]);
