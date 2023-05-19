<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190306050919 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/m_oauth_clients.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/t_oauth_access_tokens.sql')));
        $this->addSql(file_get_contents(realpath(__DIR__ . '/../dumps/t_oauth_refresh_tokens.sql')));
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $sql = <<<SQL
DROP TABLE `t_oauth_refresh_tokens`;
DROP TABLE `t_oauth_access_tokens`;
DROP TABLE `m_oauth_clients`;
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
