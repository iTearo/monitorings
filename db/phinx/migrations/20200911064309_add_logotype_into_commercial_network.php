<?php

/**
 * @noinspection AutoloadingIssuesInspection
 */

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class AddLogotypeIntoCommercialNetwork extends AbstractMigration
{
    public function up(): void
    {
        $this->query(/** @lang SQL */ 'BEGIN');

        $this->query(/** @lang SQL */ 'ALTER TABLE commercial_network ADD COLUMN logotype_file_id VARCHAR(36)');

        $this->query(/** @lang SQL */ 'COMMIT');
    }

    public function down(): void
    {
        $this->query(/** @lang SQL */ 'BEGIN');

        $this->query(/** @lang SQL */ 'ALTER TABLE commercial_network DROP COLUMN logotype_file_id');

        $this->query(/** @lang SQL */ 'COMMIT');
    }
}
