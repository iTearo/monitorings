<?php

declare(strict_types=1);

namespace Domain\Outlet\App\Dto;

use Domain\Common\Identity;

class CommercialNetworkDto
{
    public Identity $commercialNetworkId;

    public string $title;

    public ?Identity $logotypeFileId = null;

    public static function createFromArray(array $data): self
    {
        $dto = new self();
        $dto->title = $data['title'];
        $dto->logotypeFileId = isset($data['logotypeFileId']) ? Identity::fromString($data['logotypeFileId']) : null;
        return $dto;
    }
}
