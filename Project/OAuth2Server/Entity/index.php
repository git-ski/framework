<?php

namespace Project\OAuth2Server\Admin;

use Framework\ObjectManager\ObjectManager;
use Std\EntityManager\RepositoryManager;

$ObjectManager = ObjectManager::getSingleton();
$ObjectManager->get(RepositoryManager::class)->addEntityPath(__DIR__);
