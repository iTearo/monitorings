<?php

declare(strict_types=1);

use Domain\Common\Identity;
use Domain\Outlet\Data\DoctrineOutletRepository;
use Phinx\Seed\AbstractSeed;

class OutletSeed extends AbstractSeed
{
    public function getDependencies(): array
    {
        return [
            CommercialNetworkSeed::class,
        ];
    }

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
            'id' => 'd5b8cb9e-b53f-45f4-be9d-e18853e2ba18',
            'title' => 'Ашан',
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
        $streets = [
            '8 марта',
            'Малышева',
            'Металлургов',
            'Космонавтов',
            'Бебеля',
            'Токарей',
            'Щорса',
        ];

        $commercialNetworks = CommercialNetworkSeed::DATA;

        $data = [];
        for ($i = 0; $i < 95; $i++) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $data[] = [
                'id' => (string) Identity::new(),
                'commercial_network_id' => $commercialNetworks[random_int(0, count($commercialNetworks) - 1)]['id'],
                'address' => json_encode(
                    [
                        'locality'  => 'Екатеринбург',
                        'street'    => $streets[random_int(0, count($streets) - 1)],
                        'building'  => (string) random_int(1, 199),
                    ],
                    JSON_THROW_ON_ERROR
                ),
            ];
        }

        $table = $this->table(DoctrineOutletRepository::TABLE);
        $table->truncate();
        $table->insert($data)
            ->save()
        ;
    }
}
