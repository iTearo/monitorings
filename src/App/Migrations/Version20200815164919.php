<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200815164919 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create outlet table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql(<<<SQL
            CREATE TABLE outlet (
                id CHAR(36) NOT NULL,
                commercial_network_id CHAR(36) NOT NULL,
                address LONGTEXT NOT NULL,
                created_at TIMESTAMP NOT NULL,
                updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id)
            )
        SQL);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE outlet');
    }
}
