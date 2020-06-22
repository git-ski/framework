<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'secure' => [
        'blacklist' => [
            'mail' => [
                'hostname' => [
                    'example.com', 'qq.com'
                ],
            ]
        ],
        'recaptcha' => [
            'v2' => [
                'siteKey'   => '',
                'secret'    => '',
            ]
        ]
    ],
];
