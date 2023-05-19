<?php

namespace Project\AdminUser\Admin;

use Framework\ObjectManager\ObjectManager;
use Std\EntityManager\RepositoryManager;
use Project\AdminUser\Admin\Authentication\EventListenerManager as AuthenticationEventListenerManager;

$ObjectManager = ObjectManager::getSingleton();
$ObjectManager->get(AuthenticationEventListenerManager::class)->initListener();
