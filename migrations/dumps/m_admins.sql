DROP TABLE IF EXISTS `m_admins`;

CREATE TABLE `m_admins` (
  `m_admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'M管理者ID',
  `login` varchar(30) NOT NULL COMMENT '管理者ID',
  `admin_name` varchar(30) NOT NULL COMMENT '管理者名',
  `admin_kana` varchar(30) DEFAULT NULL COMMENT '管理者名（カナ）',
  `avatar` varchar(64) DEFAULT NULL COMMENT 'アバター',
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
  PRIMARY KEY (`m_admin_id`),
  KEY `ik_login` (`login`,`delete_flag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='M管理者';

INSERT INTO `m_admins` (`m_admin_id`, `login`, `admin_name`, `admin_kana`, `avatar`, `admin_password`, `temp_password_flag`, `email`, `last_login_date`, `show_priority`, `create_date`, `create_time`, `create_admin_id`, `update_date`, `update_time`, `update_admin_id`, `delete_flag`)
VALUES
  (1,'admin','システム管理者','','','\$2y\$10\$rnuMV8q3mlTaDONIgrBiJeMOUj5gFz0XY0iTy00Oc.uVhYzRMQYpy',0,'gpgkd906@gmail.com','2018-04-06 11:27:13',1,'2018-04-06','00:00:00',NULL,'2018-04-06','11:27:13',1,0);

