DROP TABLE IF EXISTS `t_role_resources`;

CREATE TABLE `t_role_resources` (
  `t_role_resource_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'TロールリソースID',
  `m_role_id` int(10) unsigned NOT NULL COMMENT 'MロールID',
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'リソース特権名',
  `resource` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'リソース',
  `privilege` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '特権',
  `resource_group` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT 'リソースグループ',
  `grantable_flag` int(11) NOT NULL COMMENT '許可フラグ [0:許可しない 1:許可する]',
  PRIMARY KEY (`t_role_resource_id`),
  KEY `k_group` (`resource_group`),
  KEY `fk_m_role_id` (`m_role_id`),
  CONSTRAINT `fk_role_id_trr` FOREIGN KEY (`m_role_id`) REFERENCES `m_roles` (`m_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
