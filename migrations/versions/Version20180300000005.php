<?php declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 * 履歴モジュール
 */
final class Version20180300000005 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/l_admin_operations.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/l_customer_operations.sql')));
    }

    public function down(Schema $schema) : void
    {
        $sql = <<<SQL
DROP TABLE `l_admin_operations`;
DROP TABLE `l_customer_operations`;
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
