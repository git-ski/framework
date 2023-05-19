DROP TABLE IF EXISTS `m_roles`;

CREATE TABLE `m_roles` (
  `m_role_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'MロールID',
  `role` varchar(100) NOT NULL COMMENT 'ロール名',
  `show_priority` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '表示順',
  `create_date` date NOT NULL COMMENT '作成日',
  `create_time` time NOT NULL COMMENT '作成時',
  `create_admin_id` int(10) unsigned DEFAULT NULL COMMENT '作成管理ユーザーID',
  `update_date` date NOT NULL COMMENT '更新日',
  `update_time` time NOT NULL COMMENT '更新時',
  `update_admin_id` int(10) unsigned DEFAULT NULL COMMENT '更新管理ユーザーID',
  `delete_flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '削除フラグ [0:未削除 1:削除済み]',
  PRIMARY KEY (`m_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='M管理者ロール';

INSERT INTO `m_roles` (`m_role_id`, `role`, `show_priority`, `create_date`, `create_time`, `create_admin_id`, `update_date`, `update_time`, `update_admin_id`, `delete_flag`)
VALUES
  (1,'システム管理者',1,'2018-01-25','00:00:00',NULL,'2018-01-25','00:00:00',NULL,0);
