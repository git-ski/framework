<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'mailer' => [
        'default_from' => 'dev@gitski.work',
        'default_replyto' => 'dev@gitski.work',
        'return_path' => 'dev@gitski.work',
        'adapter' => [
            'symfony' => [
                'host' => 'smtp.gmail.com',
                'connection_class' => 'login',
                'port' => 465,
                'user' => '',
                'pass' => '',
                'encryption' => 'ssl',
            ]
        ]
    ]
];
