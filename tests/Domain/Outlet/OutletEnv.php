<?php

declare(strict_types=1);

namespace Domain\Outlet;

use Domain\Common\Identity;
use Domain\Outlet\App\Dto\AddressDto;
use Domain\Outlet\App\Dto\OutletDto;
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
        $outletDto = new OutletDto();
        $outletDto->address = self::createAddressDto();
        $outletDto->commercialNetworkId = Identity::new();
        return $outletDto;
    }
}
