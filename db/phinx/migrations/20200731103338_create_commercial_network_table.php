<?php

/**
 * @noinspection AutoloadingIssuesInspection
 */

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateCommercialNetworkTable extends AbstractMigration
{
    public function up(): void
    {
        $this->query(/** @lang SQL */ 'BEGIN');
        $this->query(/** @lang SQL */ <<<SQL
            CREATE TABLE `commercial_network` (
                id CHAR(36) NOT NULL,
                title VARCHAR(128) NOT NULL,
                created_at TIMESTAMP NOT NULL,
                updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id)
            )
        SQL);
        $this->query(/** @lang SQL */ 'COMMIT');
    }

    public function down(): void
    {
        $this->query(/** @lang SQL */ 'BEGIN');
        $this->query(/** @lang SQL */ 'DROP TABLE `commercial_network`');
        $this->query(/** @lang SQL */ 'COMMIT');
    }
}
