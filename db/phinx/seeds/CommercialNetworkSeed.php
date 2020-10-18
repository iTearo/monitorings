<?php

declare(strict_types=1);

use Domain\Outlet\Data\DoctrineCommercialNetworkRepository;
use Phinx\Seed\AbstractSeed;

class CommercialNetworkSeed extends AbstractSeed
{
    public const DATA = [
        [
            'id' => '4d2b6943-e118-4a01-a59b-d58a1507cf2e',
            'title' => 'Ашан',
        ],
        [
            'id' => '224c723b-766d-49c3-83e9-8c61b4f75675',
            'title' => 'Метро',
        ],
        [
            'id' => '524d271a-920d-4a5d-89ad-682d49ecadab',
            'title' => 'Лента',
        ],
        [
            'id' => '8fbf9264-b910-4a33-8f4c-684043c0e64d',
            'title' => 'Пятерочка',
        ],
        [
            'id' => '3292fb96-d343-4c04-abf8-7594181fdac5',
            'title' => 'Мегамарт',
        ],
    ];

    public function run(): void
    {
        $table = $this->table(DoctrineCommercialNetworkRepository::TABLE);
        $table->truncate();
        $table->insert(self::DATA)
            ->save()
        ;
    }
}
