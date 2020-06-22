<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'logger' => [
        /**
         * 使用シーンにより、切り替え用のログファイル
         */
        'handlers' => [
            'default'       => 'log://debug.log',
            'sql'           => 'log://sql.log',
            'error'         => 'log://error.log',
            'batch'         => 'log://batch.log',
            'api'           => 'log://api.log',
            'order.error'   => 'log://order.error.log',
        ],
        /**
         * logrotate設定
         * ※この設定はmonologに依存するため、出来ればシステムのlogrotateを利用すべきである。
         */
        // 'logrotate' => [
        //     'maxFiles' => 30,
        // ],
        /**
         * この機能はいるか？
         */
        // 'slack' => [
        //     'webhook'               => '',
        //     'channel'               => '',
        //     'username'              => '',
        //     'useAttachment'         => true,
        //     'iconEmoji'             => ':boom:',
        //     'useShortAttachment'    => true,
        //     'includeContextAndExtra'=> true,
        //     'level'                 => 100, // Debug
        // ],
    ],
];
