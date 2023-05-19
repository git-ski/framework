DROP TABLE IF EXISTS `r_admin_roles`;

CREATE TABLE `r_admin_roles` (
    `r_admin_role_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'R管理者ロールID',
    `m_admin_id` int(10) unsigned NOT NULL COMMENT 'M管理者ID',
    `m_role_id` int(10) unsigned NOT NULL COMMENT 'MロールID',
    PRIMARY KEY (`r_admin_role_id`),
    KEY `fk_m_admin_id` (`m_admin_id`),
    KEY `fk_m_role_id` (`m_role_id`),
    CONSTRAINT `fk_admin_id_rar` FOREIGN KEY (`m_admin_id`) REFERENCES `m_admins` (`m_admin_id`),
    CONSTRAINT `fk_role_id_rar` FOREIGN KEY (`m_role_id`) REFERENCES `m_roles` (`m_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='R管理者ロール';
INSERT INTO `r_admin_roles` (`m_admin_id`, `m_role_id`)
VALUES
	(1, 1);
INSERT INTO `t_role_resources` (`m_role_id`, `name`, `resource`, `privilege`, `resource_group`, `grantable_flag`)
VALUES
	(1, 'ログイン', 'admin/login', '', '機能・画面（管理側）', 1),
	(1, 'ログアウト', 'admin/logout', '', '機能・画面（管理側）', 1),
	(1, '管理者 登録', 'admin/users/register', '', '機能・画面（管理側）', 1),
	(1, '管理者 一覧', 'admin/users/list', '', '機能・画面（管理側）', 1),
	(1, '管理者 編集', 'admin/users/edit', '', '機能・画面（管理側）', 1),
	(1, '管理者 削除', 'admin/users/delete', '', '機能・画面（管理側）', 1),
	(1, 'パスワード変更', 'admin/users/password', '', '機能・画面（管理側）', 1),
	(1, 'Dashboard', 'admin', '', '機能・画面（管理側）', 1),
	(1, 'File 登録', 'admin/file/register', '', '機能・画面（管理側）', 1),
	(1, 'File 一覧', 'admin/file/list', '', '機能・画面（管理側）', 1),
	(1, 'File 削除', 'admin/file/delete', '', '機能・画面（管理側）', 1),
	(1, 'お問い合わせ一覧', 'admin/inquiry/list', '', '機能・画面（管理側）', 1),
	(1, 'Inquiry 編集', 'admin/inquiry/edit', '', '機能・画面（管理側）', 1),
	(1, 'お問い合わせ種類追加', 'admin/inquiryType/register', '', '機能・画面（管理側）', 1),
	(1, 'お問い合わせ種類一覧', 'admin/inquiryType/list', '', '機能・画面（管理側）', 1),
	(1, 'InquiryType 編集', 'admin/inquiryType/edit', '', '機能・画面（管理側）', 1),
	(1, 'InquiryType 削除', 'admin/inquiryType/delete', '', '機能・画面（管理側）', 1),
	(1, 'ロール 登録', 'admin/role/register', '', '機能・画面（管理側）', 1),
	(1, 'ロール 一覧', 'admin/role/list', '', '機能・画面（管理側）', 1),
	(1, 'ロール 編集', 'admin/role/edit', '', '機能・画面（管理側）', 1),
	(1, 'ロール 削除', 'admin/role/delete', '', '機能・画面（管理側）', 1),
	(1, '権限設定', 'admin/permission/configuration', '', '機能・画面（管理側）', 1);
