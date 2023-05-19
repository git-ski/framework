<?php
declare(strict_types=1);
namespace Project\Dev\Console;

use Std\RouterManager\RouterManagerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->get(RouterManagerInterface::class)->get()
    ->register([
        'dev:module:create' => Controller\Module\CreateController::class,
        'dev:module:crud:create' => Controller\Module\CrudCreateController::class,
        'dev:module:entity:create' => Controller\Module\EntityCreateController::class,
        'dev:module:test:create' => Controller\Module\TestCreateController::class,
        'dev:entity:i18n:assistant' => Controller\Model\EntityI18nAssistantController::class,
        'dev:doctrine' => Controller\Model\DoctrineController::class,
        'dev:module:message:create' => Controller\Module\MessageCreateController::class,
        'dev:module:page:create' => Controller\Module\PageCreateController::class,
        'dev:module:restful:create' => Controller\Module\RestfulCreateController::class,
        'dev:module:console:create' => Controller\Module\ConsoleCreateController::class,
        'dev:module:package:prepare' => Controller\Module\PreparePackageController::class,
    ]);
