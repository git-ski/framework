<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 * 管理者ユーザーモジュール
 */
final class Version20180300000002 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/m_admins.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/l_admins.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/w_login_attempts.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/t_admin_secrets.sql')));
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $sql = <<<SQL
DROP TABLE `t_admin_secrets`;
DROP TABLE `w_login_attempts`;
DROP TABLE `l_admins`;
DROP TABLE `m_admins`;
SQL;
        $this->addSql($sql);
    }

    protected function addSql($sql, array $params = [], array $types = []) : void
    {
        $sqls = explode(';', $sql);
        foreach ($sqls as $sql) {
            $sql = trim($sql);
            if (!$sql) {
                continue;
            }
            parent::addSql($sql . ';');
        }
    }
}
