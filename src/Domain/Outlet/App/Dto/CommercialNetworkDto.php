<?php

declare(strict_types=1);

namespace Domain\Outlet\App\Dto;

use Domain\File\Domain\FileIdentity;
use Domain\Outlet\Domain\CommercialNetworkIdentity;

class CommercialNetworkDto
{
    public CommercialNetworkIdentity $commercialNetworkId;

    public string $title;

    public ?FileIdentity $logotypeFileId = null;

    public static function createFromArray(array $data): self
    {
        $dto = new self();
        $dto->title = $data['title'];
        $dto->logotypeFileId = isset($data['logotypeFileId']) ? FileIdentity::fromString($data['logotypeFileId']) : null;
        return $dto;
    }
}
