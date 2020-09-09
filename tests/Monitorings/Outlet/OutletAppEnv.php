<?php

declare(strict_types=1);

namespace Monitorings\Outlet;

use Monitorings\Outlet\Data\DoctrineCommercialNetworkRepository;
use Monitorings\Outlet\Data\DoctrineOutletRepository;
use Monitorings\Outlet\Domain\Address;
use Monitorings\Outlet\Domain\CommercialNetwork;
use Monitorings\Outlet\Domain\CommercialNetworkRepository;
use Monitorings\Outlet\Domain\Outlet;
use Monitorings\Outlet\Domain\OutletRepository;
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
