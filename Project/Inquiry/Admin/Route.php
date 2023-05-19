<?php
namespace Project\Inquiry\Admin;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'admin/inquiry/list'         => Controller\Inquiry\ListController::class,
        'admin/inquiry/edit'         => Controller\Inquiry\EditController::class,
        'admin/inquiry/type/register' => Controller\InquiryType\RegisterController::class,
        'admin/inquiry/type/list'     => Controller\InquiryType\ListController::class,
        'admin/inquiry/type/edit'     => Controller\InquiryType\EditController::class,
        'admin/inquiry/action/register' => Controller\InquiryAction\RegisterController::class,
        'admin/inquiry/action/list' => Controller\InquiryAction\ListController::class,
        'admin/inquiry/action/edit' => Controller\InquiryAction\EditController::class,
      ]);
