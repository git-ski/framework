DROP TABLE IF EXISTS `m_inquiry_types`;

CREATE TABLE `m_inquiry_types` (
  `m_inquiry_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'M問合せ種類ID',
  `type` varchar(128) DEFAULT NULL COMMENT '種類名',
  `description` text COMMENT '種類説明',
  `show_priority` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '表示順',
  `create_date` date NOT NULL COMMENT '作成日',
  `create_time` time NOT NULL COMMENT '作成時',
  `create_admin_id` int(10) unsigned DEFAULT NULL COMMENT '作成管理ユーザーID',
  `update_date` date NOT NULL COMMENT '更新日時',
  `update_time` time NOT NULL COMMENT '更新時',
  `update_admin_id` int(10) unsigned DEFAULT NULL COMMENT '更新管理ユーザーID',
  `delete_flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '削除フラグ [0:未削除 1:削除済み]',
  PRIMARY KEY (`m_inquiry_type_id`),
  KEY `k_type_mit` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='M問合せ種類';

INSERT INTO `m_inquiry_types` (`m_inquiry_type_id`, `type`, `description`, `show_priority`, `create_date`, `create_time`, `create_admin_id`, `update_date`, `update_time`, `update_admin_id`, `delete_flag`)
VALUES
  (1,'テスト','テスト',1,'2018-03-08','19:18:57',1,'2018-03-08','19:18:57',1,0);