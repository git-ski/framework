<?php
namespace Project\Inquiry\Api;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'rest/v1/admin/inquiry'     => Controller\AdminInquiryListController::class,
        'rest/v1/admin/inquiry/type' => Controller\AdminInquiryTypeListController::class,
        'rest/v1/admin/inquiry/action' => Controller\AdminInquiryActionListController::class,
        'rest/v1/admin/faq'         => Controller\FaqController::class,
      ]);
