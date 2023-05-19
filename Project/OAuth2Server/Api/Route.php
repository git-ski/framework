<?php
namespace Project\OAuth2Server\Api;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'rest/v1/oauth/access_token' => Controller\OauthAccessTokenController::class,
        'rest/v1/oauth/authorize' => Controller\OauthAuthorizeController::class,
        'rest/v1/oauth/profile' => Controller\OauthProfileController::class,
      ]);
