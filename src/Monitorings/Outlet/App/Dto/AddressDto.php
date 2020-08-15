<?php

declare(strict_types=1);

namespace Monitorings\Outlet\App\Dto;

class AddressDto
{
    public string $locality;

    public string $street;

    public string $building;

    public static function createFromArray(array $data): self
    {
        $dto = new self();
        $dto->locality = $data['locality'];
        $dto->street = $data['street'];
        $dto->building = $data['building'];
        return $dto;
    }
}
