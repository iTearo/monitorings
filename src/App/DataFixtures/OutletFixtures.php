<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Monitorings\Outlet\Domain\Address;
use Monitorings\Outlet\Domain\CommercialNetwork;
use Monitorings\Outlet\Domain\Outlet;

class OutletFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $commercialNetworks = [
            new CommercialNetwork('Ашан'),
            new CommercialNetwork('Метро'),
            new CommercialNetwork('Лента'),
            new CommercialNetwork('Мегамарт'),
            new CommercialNetwork('Монетка'),
            new CommercialNetwork('Пятерочка'),
        ];

        $streets = [
            '8 марта',
            'Малышева',
            'Металлургов',
            'Космонавтов',
            'Бебеля',
            'Токарей',
            'Щорса',
        ];

        foreach ($commercialNetworks as $commercialNetwork) {
            $manager->persist($commercialNetwork);
        }

        for ($i = 0; $i < 95; $i++) {
            $outlet = new Outlet(
                $commercialNetworks[random_int(0,\count($commercialNetworks) - 1)],
                new Address(
                    (string) random_int(1,199),
                    $streets[random_int(0,\count($streets) - 1)],
                    'Екатеринбург'
                )
            );
            $manager->persist($outlet);
        }

        $manager->flush();
    }
}
