<?php

declare(strict_types=1);

namespace Domain\Outlet\App\Dto;

use Domain\Common\Identity;

class OutletDto
{
    public Identity $commercialNetworkId;

    public AddressDto $address;

    public static function createFromArray(array $data): self
    {
        $dto = new self();
        $dto->commercialNetworkId = Identity::fromString($data['commercialNetwork']);
        $dto->address = AddressDto::createFromArray($data['address']);
        return $dto;
    }
}
