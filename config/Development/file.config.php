<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'file' => [
        'schema' => [
            'public://' => ROOT_DIR . 'public/',
            'private://'=> ROOT_DIR . 'var/private/',
            'temp://'   => ROOT_DIR . 'var/temp/',
            'data://'   => ROOT_DIR . 'var/data/',
            'log://'    => ROOT_DIR . 'var/log/',
            'download://'    => ROOT_DIR . 'var/download/'
        ],
        'sync' => [
            [
                'adapter' => 'sftp',
                'options' => [
                    'host' => 'sftp_server',
                    'port' => 22,
                    'username' => 'foo',
                    'password' => 'pass',
                    'root' => '/',
                    'timeout' => 10,
                ]
            ],
            // [
            //     'adapter' => 's3',
            //     'options' => [
            //         'credentials' => [
            //             'key'    => '',
            //             'secret' => '',
            //         ],
            //         'region' => 'ap-northeast-1',
            //         'version' => 'latest',
            //         'bucket'  => '',
            //     ]
            // ]
        ]
    ]
];
