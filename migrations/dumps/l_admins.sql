DROP TABLE IF EXISTS `l_admins`;

CREATE TABLE `l_admins` (
  `l_admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'L管理者履歴ID',
  `log_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '履歴タイプ[1: 管理者情報変更 2: パスワード変更]',
  `m_admin_id` int(10) unsigned DEFAULT NULL COMMENT 'M管理者ID',
  `login` varchar(64) NOT NULL COMMENT '管理者ID',
  `admin_name` varchar(64) DEFAULT '' COMMENT '管理者名',
  `admin_kana` varchar(64) DEFAULT NULL COMMENT '管理者名（カナ）',
  `admin_password` varchar(256) NOT NULL COMMENT '管理者パスワード',
  `temp_password_flag` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '仮パスワードフラグ',
  `email` varchar(128) DEFAULT NULL COMMENT '管理者メールアドレス',
  `last_login_date` datetime DEFAULT NULL COMMENT '最終ログイン日',
  `show_priority` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '表示順',
  `create_date` date NOT NULL COMMENT '作成日',
  `create_time` time NOT NULL COMMENT '作成時',
  `create_admin_id` int(10) unsigned DEFAULT NULL COMMENT '作成管理ユーザーID',
  `update_date` date NOT NULL COMMENT '更新日',
  `update_time` time NOT NULL COMMENT '更新時',
  `update_admin_id` int(10) unsigned DEFAULT NULL COMMENT '更新管理ユーザーID',
  `delete_flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '削除フラグ [0:未削除 1:削除済み]',
  PRIMARY KEY (`l_admin_id`),
  KEY `idx_id_type` (`m_admin_id`,`log_type`),
  CONSTRAINT `fk_m_admin_id_la` FOREIGN KEY (`m_admin_id`) REFERENCES `m_admins` (`m_admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='L管理者履歴';
