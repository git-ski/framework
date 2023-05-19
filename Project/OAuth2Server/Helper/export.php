<?php

namespace Project\OAuth2Server\Helper;

use Framework\ObjectManager\ObjectManager;
use Project\OAuth2Server\Helper\AuthorizationServerInterface;
use Project\OAuth2Server\Helper\AuthorizationServerFactory;

ObjectManager::getSingleton()->export([
    AuthorizationServerInterface::class => AuthorizationServerFactory::class,
    ResourceServerInterface::class      => ResourceServerFactory::class
]);
