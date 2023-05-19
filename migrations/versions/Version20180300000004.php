<?php declare(strict_types = 1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 * 権限モジュール
 */
class Version20180300000004 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/m_roles.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/t_role_resources.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/r_admin_groups.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/r_admin_roles.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/t_admin_acls.sql')));
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $sql = <<<SQL
DROP TABLE t_role_resources;
DROP TABLE r_admin_groups;
DROP TABLE r_admin_roles;
DROP TABLE t_admin_acls;
DROP TABLE m_roles;
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
