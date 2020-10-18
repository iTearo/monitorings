<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Domain\Outlet\Domain\CommercialNetworkIdentity;

class CommercialNetworkIdentityType extends GuidType
{
    public const TYPE_NAME = 'commercial_network_identity_type';

    public function getName(): string
    {
        return self::TYPE_NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?CommercialNetworkIdentity
    {
        return $value === null ? null : CommercialNetworkIdentity::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof CommercialNetworkIdentity ? (string) $value : $value;
    }
}
