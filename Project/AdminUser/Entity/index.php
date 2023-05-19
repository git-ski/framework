<?php

namespace Project\AdminUser\Admin;

use Framework\ObjectManager\ObjectManager;
use Std\EntityManager\RepositoryManager;

$ObjectManager = ObjectManager::getSingleton();
$ObjectManager->get(RepositoryManager::class)->addEntityPath(__DIR__);
