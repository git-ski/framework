<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 * Customerモジュール
 */
final class Version20180300000003 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/l_customer_temporaries.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/m_customers.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/l_customers.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/w_customer_login_attempts.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/w_customer_reminders.sql')));
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $sql = <<<SQL
DROP TABLE `l_customer_temporaries`;
DROP TABLE `l_customers`;
DROP TABLE `w_customer_login_attempts`;
DROP TABLE `w_customer_reminders`;
DROP TABLE `m_customers`;
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
