<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'model' => [
        'connection' => [
            'type'      => 'mysql',
            'driver'    => 'pdo_mysql',
            'user'      => 'docker',
            'password'  => 'docker',
            'host'      => 'db',
            'dbname'    => 'docker',
            'charset'   => 'utf8mb4',
            'driverOptions' => [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
            ]
        ],
        'entityManager' => [
            'proxyDir' => ROOT_DIR . 'var/Doctrine/Proxy',
        ]
    ]
];
