<?php
namespace Project\AdminUser\Admin;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'admin/login' => Controller\LoginController::class,
        'admin/logout' => Controller\LogoutController::class,
        'admin/users/register' => Controller\AdminUser\RegisterController::class,
        'admin/users/list' => Controller\AdminUser\ListController::class,
        'admin/users/edit' => Controller\AdminUser\EditController::class,
        'admin/users/delete' => Controller\AdminUser\DeleteController::class,
        'admin/users/password' => Controller\AdminUser\PasswordController::class,
        'admin/users/other_password' => Controller\AdminUser\OtherPasswordController::class,
        'admin/configuration' => Controller\Configuration\ConfigurationController::class,
    ]);
