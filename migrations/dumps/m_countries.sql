DROP TABLE IF EXISTS `m_countries`;

CREATE TABLE `m_countries` (
  `m_country_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'M国别ID',
  PRIMARY KEY (`m_country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='M国别';