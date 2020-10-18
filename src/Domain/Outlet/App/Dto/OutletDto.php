<?php

declare(strict_types=1);

namespace Domain\Outlet\App\Dto;

use Domain\Outlet\Domain\CommercialNetworkIdentity;

class OutletDto
{
    public CommercialNetworkIdentity $commercialNetworkId;

    public AddressDto $address;

    public static function createFromArray(array $data): self
    {
        $dto = new self();
        $dto->commercialNetworkId = CommercialNetworkIdentity::fromString($data['commercialNetwork']);
        $dto->address = AddressDto::createFromArray($data['address']);
        return $dto;
    }
}
