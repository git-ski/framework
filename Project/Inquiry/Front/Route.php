<?php
namespace Project\Inquiry\Front;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        '[locale/]inquiry' => Controller\Inquiry\InquiryController::class,
        '[locale/]inquiry-top' => Controller\Inquiry\InquiryTopController::class,
      ]);
