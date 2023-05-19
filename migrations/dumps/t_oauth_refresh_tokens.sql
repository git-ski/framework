DROP TABLE IF EXISTS `t_oauth_refresh_tokens`;

CREATE TABLE `t_oauth_refresh_tokens` (
  `t_oauth_refresh_token_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'MリフレッシュトークンID',
  `t_oauth_access_token_id` int(10) unsigned NOT NULL COMMENT 'マスタOAuthクライアントID',
  `refresh_token` varchar(256) NOT NULL COMMENT 'MロールID',
  `create_datetime` datetime NOT NULL COMMENT '作成日',
  `update_datetime` datetime NOT NULL COMMENT '更新日',
  `expiry_datetime` datetime NOT NULL COMMENT '失効日',
  `delete_flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '削除フラグ [0:未削除 1:削除済み]',
  PRIMARY KEY (`t_oauth_refresh_token_id`),
  KEY `fk_t_oauth_access_token_id_tort` (`t_oauth_access_token_id`),
  CONSTRAINT `fk_t_oauth_access_token_id_tort` FOREIGN KEY (`t_oauth_access_token_id`) REFERENCES `t_oauth_access_tokens` (`t_oauth_access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Mリフレッシュトークン';