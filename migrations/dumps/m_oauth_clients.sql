DROP TABLE IF EXISTS `m_oauth_clients`;

CREATE TABLE `m_oauth_clients` (
  `m_oauth_client_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'マスタOAuthクライアントID',
  `name` varchar(100) NOT NULL COMMENT 'clientId',
  `password` varchar(256) NOT NULL COMMENT 'clientSecret',
  `redirect_uri` text NOT NULL COMMENT 'redirectUri',
  `create_date` date NOT NULL COMMENT '作成日',
  `create_time` time NOT NULL COMMENT '作成時',
  `create_admin_id` int(10) unsigned DEFAULT NULL COMMENT '作成管理ユーザーID',
  `update_date` date NOT NULL COMMENT '更新日',
  `update_time` time NOT NULL COMMENT '更新時',
  `update_admin_id` int(10) unsigned DEFAULT NULL COMMENT '更新管理ユーザーID',
  `delete_flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '削除フラグ [0:未削除 1:削除済み]',
  PRIMARY KEY (`m_oauth_client_id`),
  KEY `idx_name_moc` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='OAuthクライアント';