DROP TABLE IF EXISTS `t_admin_acls`;

CREATE TABLE `t_admin_acls` (
  `t_admin_acl_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'T管理者権限管理ID',
  `m_admin_id` int(10) unsigned NOT NULL COMMENT 'M管理者ID',
  `acl` blob NOT NULL COMMENT 'access control list',
  `test` date DEFAULT NULL,
  PRIMARY KEY (`t_admin_acl_id`),
  KEY `fk_m_admin_id` (`m_admin_id`),
  CONSTRAINT `fk_admin_id_taa` FOREIGN KEY (`m_admin_id`) REFERENCES `m_admins` (`m_admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='T管理者権限管理';
