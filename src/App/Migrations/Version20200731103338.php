<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200731103338 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create commercial_network table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql(<<<SQL
            CREATE TABLE commercial_network (
                id CHAR(36) NOT NULL,
                title VARCHAR(128) NOT NULL,
                created_at TIMESTAMP NOT NULL,
                updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id)
            )
        SQL);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE commercial_network');
    }
}
