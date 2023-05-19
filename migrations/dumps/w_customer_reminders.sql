DROP TABLE IF EXISTS `w_customer_reminders`;

CREATE TABLE `w_customer_reminders` (
  `w_customer_reminder_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'W顧客リマインダーID',
  `m_customer_id` int(10) unsigned NOT NULL COMMENT 'M顧客ID',
  `url_hash_key` varbinary(32) NOT NULL COMMENT 'url用HASHキー',
  `verify_hash_key` varbinary(32) NOT NULL COMMENT '確認用HASHキー',
  `use_flag` tinyint(3) unsigned DEFAULT '0' COMMENT '使用フラグ [0:未使用 1:使用済み]',
  `create_date` date NOT NULL COMMENT '作成日',
  `create_time` time NOT NULL COMMENT '作成時',
  `create_admin_id` int(10) unsigned DEFAULT NULL COMMENT '作成管理ユーザーID',
  `update_date` date NOT NULL COMMENT '更新日',
  `update_time` time NOT NULL COMMENT '更新時',
  `update_admin_id` int(10) unsigned DEFAULT NULL COMMENT '更新管理ユーザーID',
  `delete_flag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`w_customer_reminder_id`),
  KEY `fk_m_customer_id_wcr` (`m_customer_id`),
  CONSTRAINT `fk_m_customer_id_wcr` FOREIGN KEY (`m_customer_id`) REFERENCES `m_customers` (`m_customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='W顧客リマインダー';
