<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'mailer' => [
        'default_from' => [
            '' => ''
        ],
        'default_replyto' => [
            '' => ''
        ],
        'return_path' => '',
        'swift-mail' => [
            'host' => 'smtp.gmail.com',
            'connection_class' => 'login',
            'port' => 465,
            'user' => '',
            'pass' => '',
            'encryption' => 'ssl',
        ]
    ]
];
