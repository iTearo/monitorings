<?php

declare(strict_types=1);

namespace TestTools;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

class DbTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        /** @noinspection PhpUnhandledExceptionInspection */
        self::getEntityManager()->clear();
    }

    protected static function deleteAllFromTables(...$tables): void
    {
        if (empty($tables)) {
            return;
        }

        $tablesList = static::makeTablesListRecursively($tables);

        foreach (array_unique($tablesList) as $table) {
            /** @noinspection PhpUnhandledExceptionInspection */
            self::getConnection()->query('DELETE FROM ' . $table);
        }
    }

    private static function makeTablesListRecursively($tables): array
    {
        $tablesList = [];
        foreach ($tables as $item) {
            if (\is_array($item)) {
                $itemTables = static::makeTablesListRecursively($item);

                /** @noinspection SlowArrayOperationsInLoopInspection */
                $tablesList = array_merge($tablesList, $itemTables);
            } else {
                $tablesList[] = $item;
            }
        }
        return $tablesList;
    }

    private static function getConnection(): Connection
    {
        return self::getContainer()->get('doctrine.dbal.default_connection');
    }

    private static function getEntityManager(): EntityManager
    {
        return self::getContainer()->get('doctrine.orm.default_entity_manager');
    }
}
