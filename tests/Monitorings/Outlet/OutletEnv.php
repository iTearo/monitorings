<?php

declare(strict_types=1);

namespace Monitorings\Outlet;

use Monitorings\Identity;
use Monitorings\Outlet\App\Dto\AddressDto;
use Monitorings\Outlet\App\Dto\OutletDto;
use TestTools\TestEnv;

class OutletEnv extends TestEnv
{
    public static function createAddressDto(): AddressDto
    {
        $addressDto = new AddressDto();
        $addressDto->building = '1';
        $addressDto->street = 'Ленина';
        $addressDto->locality = 'Екатеринбург';
        return $addressDto;
    }
    public static function createOutletDto(): OutletDto
    {
        $addressDto = new OutletDto();
        $addressDto->address = self::createAddressDto();
        $addressDto->commercialNetworkId = Identity::new();
        return $addressDto;
    }
}
