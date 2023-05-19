DROP TABLE IF EXISTS `t_admin_secrets`;

CREATE TABLE `t_admin_secrets` (
  `t_admin_secret_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'T管理者秘密鍵ID',
  `m_admin_id` int(10) unsigned NOT NULL COMMENT 'M管理者ID',
  `secret` varchar(128) NOT NULL COMMENT 'MロールID',
  `code` varchar(64) NOT NULL COMMENT '使用者コード',
  PRIMARY KEY (`t_admin_secret_id`),
  KEY `fk_m_admin_id` (`m_admin_id`),
  KEY `vendor` (`m_admin_id`,`code`),
  CONSTRAINT `fk_admin_id_tas` FOREIGN KEY (`m_admin_id`) REFERENCES `m_admins` (`m_admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='T管理者秘密鍵';
