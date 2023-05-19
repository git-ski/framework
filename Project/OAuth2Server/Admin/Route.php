<?php
namespace Project\OAuth2Server\Admin;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'admin/oauthClient/register' => Controller\OauthClient\RegisterController::class,
        'admin/oauthClient/list' => Controller\OauthClient\ListController::class,
        'admin/oauthClient/edit' => Controller\OauthClient\EditController::class,
        'admin/oauthClient/delete' => Controller\OauthClient\DeleteController::class,
      ]);
