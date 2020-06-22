<?php
declare(strict_types=1);
namespace Std\EntityManager;

use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->export([
    EntityManagerInterface::class => Doctrine\EntityManagerFactory::class,
]);
