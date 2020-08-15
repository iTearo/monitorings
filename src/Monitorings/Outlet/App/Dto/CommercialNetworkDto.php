<?php

declare(strict_types=1);

namespace Monitorings\Outlet\App\Dto;

use Monitorings\Identity;

class CommercialNetworkDto
{
    public Identity $commercialNetworkId;

    public string $title;

    public static function createFromArray(array $data): self
    {
        $dto = new self();
        $dto->title = $data['title'];
        return $dto;
    }
}
