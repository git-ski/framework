<?php
declare(strict_types=1);
namespace Project\Base\Front;

use Std\Controller\ControllerInterface;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->export([
    ControllerInterface::class => Controller\NotFoundController::class
]);
