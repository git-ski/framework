# ************************************************************
# Sequel Pro SQL dump
# バージョン 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# ホスト: 127.0.0.1 (MySQL 5.7.20-log)
# データベース: docker
# 作成時刻: 2018-12-14 08:17:22 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# テーブルのダンプ m_inquiry_actions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `m_inquiry_actions`;

CREATE TABLE `m_inquiry_actions` (
  `m_inquiry_action_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'M問合せアクションID',
  `action` varchar(128) DEFAULT NULL COMMENT 'アクション名',
  `description` text COMMENT '説明',
  `show_priority` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '表示順',
  `create_date` date NOT NULL COMMENT '作成日',
  `create_time` time NOT NULL COMMENT '作成時',
  `create_admin_id` int(10) unsigned DEFAULT NULL COMMENT '作成管理ユーザーID',
  `update_date` date NOT NULL COMMENT '更新日時',
  `update_time` time NOT NULL COMMENT '更新時',
  `update_admin_id` int(10) unsigned DEFAULT NULL COMMENT '更新管理ユーザーID',
  `delete_flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '削除フラグ [0:未削除 1:削除済み]',
  PRIMARY KEY (`m_inquiry_action_id`),
  KEY `k_action_mit` (`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='M問合せアクション';




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
