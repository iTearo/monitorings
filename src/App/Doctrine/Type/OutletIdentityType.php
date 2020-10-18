<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Domain\Outlet\Domain\OutletIdentity;

class OutletIdentityType extends GuidType
{
    public const TYPE_NAME = 'outlet_identity_type';

    public function getName(): string
    {
        return self::TYPE_NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?OutletIdentity
    {
        return $value === null ? null : OutletIdentity::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof OutletIdentity ? (string) $value : $value;
    }
}
