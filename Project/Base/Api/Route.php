<?php
namespace Project\Base\Api;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'rest/v0/cache' => Controller\CacheController::class,
        'rest/v1/zipcodeja' => Controller\ZipcodeJaController::class,
        'rest/v1/admin/vocabulary' => Controller\AdminVocabularyListController::class,
    ]);
