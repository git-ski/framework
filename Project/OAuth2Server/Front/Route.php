<?php
namespace Project\OAuth2Server\Front;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'oauth/authorization' => Controller\Authorization\AuthorizationController::class,
      ]);
