<?php

namespace Project\Permission\Admin;

use Framework\ObjectManager\ObjectManager;
use Std\EntityManager\RepositoryManager;

$ObjectManager = ObjectManager::getSingleton();
$ObjectManager->get(RepositoryManager::class)->addEntityPath(__DIR__);
