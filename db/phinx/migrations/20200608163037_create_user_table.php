<?php

/**
 * @noinspection AutoloadingIssuesInspection
 */

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateUserTable extends AbstractMigration
{
    public function up(): void
    {
        $this->query(/** @lang SQL */ 'BEGIN');
        $this->query(/** @lang SQL */ <<<SQL
            CREATE TABLE `user` (
                id INT AUTO_INCREMENT NOT NULL,
                email VARCHAR(180) NOT NULL,
                roles LONGTEXT NOT NULL COMMENT '(DC2Type:json)',
                password VARCHAR(255) NOT NULL, 
                is_verified TINYINT(1) NOT NULL, 
                UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), 
                PRIMARY KEY(id)
            )
        SQL);
        $this->query(/** @lang SQL */ 'COMMIT');
    }

    public function down(): void
    {
        $this->query(/** @lang SQL */ 'BEGIN');
        $this->query(/** @lang SQL */ 'DROP TABLE `user`');
        $this->query(/** @lang SQL */ 'COMMIT');
    }
}
