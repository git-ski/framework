DROP TABLE IF EXISTS `r_admin_groups`;

CREATE TABLE `r_admin_groups` (
    `r_admin_group_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'R管理者グループID',
    `m_admin_id` int(10) unsigned NOT NULL COMMENT 'M管理者ID',
    `group_id` int(10) unsigned NOT NULL COMMENT 'グループID',
    PRIMARY KEY (`r_admin_group_id`),
    KEY `fk_m_admin_id` (`m_admin_id`),
    KEY `idx_group_id` (`group_id`),
    CONSTRAINT `fk_admin_id_rag` FOREIGN KEY (`m_admin_id`) REFERENCES `m_admins` (`m_admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='R管理者グループ';
