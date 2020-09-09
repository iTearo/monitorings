<?php

/**
 * @noinspection AutoloadingIssuesInspection
 */

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateOutletTable extends AbstractMigration
{
    public function up(): void
    {
        $this->query(/** @lang SQL */ 'BEGIN');
        $this->query(/** @lang SQL */ <<<SQL
            CREATE TABLE `outlet` (
                id CHAR(36) NOT NULL,
                commercial_network_id CHAR(36) NOT NULL,
                address LONGTEXT NOT NULL,
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
        $this->query(/** @lang SQL */ 'DROP TABLE `outlet`');
        $this->query(/** @lang SQL */ 'COMMIT');
    }
}
