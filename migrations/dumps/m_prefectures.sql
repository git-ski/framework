DROP TABLE IF EXISTS `m_prefectures`;

CREATE TABLE `m_prefectures` (
  `m_prefecture_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'M省别ID',
  PRIMARY KEY (`m_prefecture_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='M省别';