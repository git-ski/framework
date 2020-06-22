<?php

namespace Project\Base\Entity;

use Framework\ObjectManager\ObjectManager;
use Project\Base\Entity\EventListenerManager;
use Std\TranslatorManager\TranslatorManagerInterface;
use Std\EntityManager\EntityInterface;
use Std\EntityManager\RepositoryManager;

$ObjectManager = ObjectManager::getSingleton();
$ObjectManager->get(RepositoryManager::class)->addEntityPath(__DIR__);
$ObjectManager->get(EventListenerManager::class)->initListener();
$ObjectManager->get(TranslatorManagerInterface::class)
    ->getTranslator(EntityInterface::class)
    ->addTranslationFilePattern(
        'phpArray',
        ROOT_DIR . 'i18n/',
        '%s/Entity.php'
    );
