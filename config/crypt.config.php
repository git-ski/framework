<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'crypt' => [
        /**
         * mcrypt か opensslを選択可能
         * ただ、mcrypt自体は非推奨にされ、php7.2以降廃止予定
         */
        'adapter' => 'openssl',
        /**
         * パスワード用暗号化機構対応
         * Laminas\Crypt\Password配下、クラス名のみ設定
         *
         */
        'password' => [
            'type' => 'Bcrypt',
        ],
        /**
         * 文字列などメッセージの暗号化モジュールの初期設定
         */
        'block_cipher' => [
            'options' => [
                /**
                 * デフォルトは AES-256 を使用
                 */
                'algo' => 'aes',
                /**
                 * gcm か ccm が選択可能、それぞれ aes-256-gcm とaes-256-ccmとなる
                 * このモードの設定は php7.1以降に有効になる。
                 * また、gcmはccmよりも高速であるため、特別な仕様でない限りgcmを使用してください。
                 *
                 * gcm: https://ja.wikipedia.org/wiki/Galois/Counter_Mode
                 * ccm: https://ja.wikipedia.org/wiki/Counter_with_CBC-MAC
                 */
                'mode' => 'gcm',
            ],
            /**
             * 暗号化キー
             */
            'encryption_key' => 'gitski encryption key',
        ],
        /**
         * ファイルの暗号化モジュールの初期設定
         */
        'file_cipher' => [
            /**
             * 暗号化キー
             */
            'encryption_key' => 'gitski encryption key',
        ],
    ]
];
