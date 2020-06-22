<?php
declare(strict_types=1);
namespace Std\MailerService;

use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->export([
    MailerServiceInterface::class => Swift\MailerService::class,
]);
