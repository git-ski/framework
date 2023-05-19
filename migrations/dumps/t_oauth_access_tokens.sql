DROP TABLE IF EXISTS `t_oauth_access_tokens`;

CREATE TABLE `t_oauth_access_tokens` (
  `t_oauth_access_token_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'MアクセストークンID',
  `m_oauth_client_id` int(10) unsigned NOT NULL COMMENT 'マスタOAuthクライアントID',
  `m_customer_id` int(10) unsigned DEFAULT NULL COMMENT 'M管理者ID',
  `m_admin_id` int(10) unsigned DEFAULT NULL COMMENT 'M管理者ID',
  `access_token` varchar(256) NOT NULL COMMENT 'MロールID',
  `scopes` text COMMENT 'スコープ',
  `create_datetime` datetime NOT NULL COMMENT '作成日',
  `update_datetime` datetime NOT NULL COMMENT '更新日',
  `expiry_datetime` datetime NOT NULL COMMENT '失効日',
  `delete_flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '削除フラグ [0:未削除 1:削除済み]',
  PRIMARY KEY (`t_oauth_access_token_id`),
  KEY `fk_m_admin_id_toat` (`m_admin_id`),
  KEY `fk_m_customer_id_toat` (`m_customer_id`),
  KEY `fk_m_oauth_client_id_toat` (`m_oauth_client_id`),
  KEY `idx_access_token_toat` (`access_token`),
  CONSTRAINT `fk_m_admin_id_toat` FOREIGN KEY (`m_admin_id`) REFERENCES `m_admins` (`m_admin_id`),
  CONSTRAINT `fk_m_customer_id_toat` FOREIGN KEY (`m_customer_id`) REFERENCES `m_customers` (`m_customer_id`),
  CONSTRAINT `fk_m_oauth_client_id_toat` FOREIGN KEY (`m_oauth_client_id`) REFERENCES `m_oauth_clients` (`m_oauth_client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Mアクセストークン';