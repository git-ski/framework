<?php
// @codingStandardsIgnoreFile
require __DIR__ . '/../env.php';
require ROOT_DIR . "vendor/autoload.php";

use Framework\Application\ConsoleApplication;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->init();

ObjectManager::getSingleton()
    ->get(ConsoleApplication::class)
    ->run();
