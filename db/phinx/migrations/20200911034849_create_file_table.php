<?php

/**
 * @noinspection AutoloadingIssuesInspection
 */

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateFileTable extends AbstractMigration
{
    public function up(): void
    {
        $this->query(/** @lang SQL */ 'BEGIN');

        $this->query(/** @lang SQL */ <<<SQL
            CREATE TABLE file_upload (
                id CHAR(36) NOT NULL,
                md5 CHAR(32) NOT NULL,
                sha1 CHAR(40) NOT NULL,
                size INTEGER NOT NULL,
                author_id CHAR(36) NULL,
                original_name VARCHAR(255) NOT NULL,
                mime_type VARCHAR(255) NOT NULL,
                path VARCHAR(255) NULL,
                status INT NOT NULL,
                created_at TIMESTAMP NOT NULL,
                updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id)
            );
        SQL);

        $this->query(/** @lang SQL */ 'COMMIT');
    }

    public function down(): void
    {
        $this->query(/** @lang SQL */ 'BEGIN');

        $this->query(/** @lang SQL */ 'DROP TABLE file_upload');

        $this->query(/** @lang SQL */ 'COMMIT');
    }
}
