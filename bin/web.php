<?php

// @codingStandardsIgnoreFile
require __DIR__ . '/../env.php';
require ROOT_DIR . "vendor/autoload.php";

// ファイルのEncodingはUTFである必要がある
use Framework\Application\HttpApplication;
use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->init();

ObjectManager::getSingleton()
    ->get(HttpApplication::class)
    ->run();
