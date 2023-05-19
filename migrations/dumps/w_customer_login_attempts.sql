DROP TABLE IF EXISTS `w_customer_login_attempts`;

CREATE TABLE `w_customer_login_attempts` (
  `w_customer_login_attempt_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'W顧客ログイン失敗ID',
  `ip` varchar(45) NOT NULL COMMENT 'ipアドレス(IPv4, IPv6)',
  `login` varchar(128) NOT NULL COMMENT 'ログインID(email)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'ログインステータス [0:ログイン失敗 1:ログイン成功]',
  `session_id` varchar(128) NOT NULL DEFAULT '' COMMENT 'ログイン成功時のセッションID',
  `create_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
  `create_admin_id` int(10) unsigned DEFAULT NULL COMMENT '作成管理ユーザーID',
  `update_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新日時',
  `update_admin_id` int(10) unsigned DEFAULT NULL COMMENT '更新管理ユーザーID',
  `delete_flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '削除フラグ [0:未削除 1:削除済み]',
  PRIMARY KEY (`w_customer_login_attempt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='W顧客ログイン失敗';