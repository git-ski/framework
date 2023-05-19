DROP TABLE IF EXISTS `l_customer_temporaries`;

CREATE TABLE `l_customer_temporaries` (
  `l_customer_temporary_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'L顧客(仮)ID',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'タイプ[1:顧客]',
  `url_hash_key` varchar(255) NOT NULL COMMENT 'url用HASHキー',
  `email` varchar(256) DEFAULT NULL COMMENT 'メールアドレス',
  `redirect_to` varchar(255) DEFAULT NULL COMMENT 'リダイレクト先',
  `use_flag` tinyint(3) unsigned DEFAULT '0' COMMENT '使用フラグ [0:未使用 1:使用済み]',
  `create_date` date NOT NULL COMMENT '作成日',
  `create_time` time NOT NULL COMMENT '作成時',
  PRIMARY KEY (`l_customer_temporary_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='L顧客(仮)';