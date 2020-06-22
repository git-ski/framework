<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 * Baseモジュール
 */
final class Version20180300000001 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/m_countries.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/m_prefectures.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/m_zipcodes_ja.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/m_vocabulary_headers.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/m_vocabulary_details.sql')));
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // this down() migration is auto-generated, please modify it to your needs
        $sql = <<<SQL
DROP TABLE `m_countries`;
DROP TABLE `m_prefectures`;
DROP TABLE `m_zipcodes_ja`;
DROP TABLE `m_vocabulary_details`;
DROP TABLE `m_vocabulary_headers`;
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
