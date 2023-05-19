<?php
namespace Project\Customer\Front;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        '[locale/]login'             => Controller\Login\LoginController::class,
        '[locale/]login_password'    => Controller\Login\LoginPasswordController::class,
        '[locale/]logout'               => Controller\Login\LogoutController::class,
        '[locale/]member/entry' => Controller\Customer\ProvisionalController::class,
        '[locale/]member/regist' => Controller\Customer\RegisterController::class,
        '[locale/]idreminder'    => Controller\Login\LoginReminderController::class,
        '[locale/]reminder'      => Controller\Login\ForgotController::class,
        '[locale/]reminder/pass'    => Controller\Login\RecoveryController::class,
        '[locale/]login/pass'   => Controller\Login\PasswordController::class,
        '[locale/]mypage'    => Controller\Customer\ProfileController::class,
        '[locale/]mypage/pass'   => Controller\Customer\PasswordController::class,
        '[locale/]mypage/member'       => Controller\Customer\EditController::class,
        '[locale/]mypage/withdraw'   => Controller\Customer\WithdrawController::class,
      ]);
