# ************************************************************
# Sequel Pro SQL dump
# バージョン 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# ホスト: 127.0.0.1 (MySQL 5.7.20-log)
# データベース: docker
# 作成時刻: 2018-12-14 08:11:50 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# テーブルのダンプ l_admin_operations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `l_admin_operations`;

CREATE TABLE `l_admin_operations` (
  `l_admin_operation_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'L管理者アクション履歴ID',
  `m_admin_id` int(10) unsigned NOT NULL COMMENT 'M管理者ID',
  `url` varchar(128) DEFAULT NULL COMMENT 'URL',
  `action` varchar(32) NOT NULL DEFAULT '' COMMENT 'アクション',
  `data` longtext COMMENT '変更内容',
  `create_date` date NOT NULL COMMENT '作成日',
  `create_time` time NOT NULL COMMENT '作成時',
  `create_admin_id` int(10) unsigned DEFAULT NULL COMMENT '作成管理ユーザーID',
  PRIMARY KEY (`l_admin_operation_id`),
  KEY `idx_m_admin_id_lao` (`m_admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='L管理者アクション履歴';

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
