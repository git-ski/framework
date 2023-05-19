<?php
namespace Project\Customer\Api;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'rest/v1/customer' => Controller\CustomerController::class,
        'rest/v1/customerlist' => Controller\CustomerListController::class,
      ]);
