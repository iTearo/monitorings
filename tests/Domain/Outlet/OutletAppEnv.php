<?php

declare(strict_types=1);

namespace Domain\Outlet;

use Domain\Outlet\Data\DoctrineCommercialNetworkRepository;
use Domain\Outlet\Data\DoctrineOutletRepository;
use Domain\Outlet\Domain\Address;
use Domain\Outlet\Domain\CommercialNetwork;
use Domain\Outlet\Domain\CommercialNetworkRepository;
use Domain\Outlet\Domain\Outlet;
use Domain\Outlet\Domain\OutletRepository;
use TestTools\TestAppEnv;

class OutletAppEnv extends TestAppEnv
{
    public static function getUsedTables(): array
    {
        return [
            DoctrineOutletRepository::TABLE,
            DoctrineCommercialNetworkRepository::TABLE,
        ];
    }

    public static function createCommercialNetwork(): CommercialNetwork
    {
        $commercialNetwork = new CommercialNetwork('commercial-network-title');
        self::getCommercialNetworkRepository()->save($commercialNetwork);
        return $commercialNetwork;
    }

    public static function createOutlet(): Outlet
    {
        $outlet = new Outlet(
            self::createCommercialNetwork(),
            new Address(
                'building',
                'street',
                'city'
            )
        );
        self::getOutletRepository()->save($outlet);
        return $outlet;
    }

    public static function getOutletRepository(): OutletRepository
    {
        return self::getEntityManager()->getRepository(Outlet::class);
    }

    public static function getCommercialNetworkRepository(): CommercialNetworkRepository
    {
        return self::getEntityManager()->getRepository(CommercialNetwork::class);
    }
}
