<?php
namespace Project\Customer\Admin;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'admin/customer/register' => Controller\Customer\RegisterController::class,
        'admin/customer/list' => Controller\Customer\ListController::class,
        'admin/customer/edit' => Controller\Customer\EditController::class,
        'admin/customer/delete' => Controller\Customer\DeleteController::class,
        'admin/customer/import' => \Project\Customer\Admin\Controller\Import\RegisterController::class
      ]);
