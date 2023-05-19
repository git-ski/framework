<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 * お問い合わせモジュール
 */
final class Version20180300000006 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/m_inquiry_actions.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/m_inquiry_types.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/t_inquiries.sql')));
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $sql = <<<SQL
DROP TABLE `t_inquiries`;
DROP TABLE `m_inquiry_types`;
DROP TABLE `m_inquiry_actions`;
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
