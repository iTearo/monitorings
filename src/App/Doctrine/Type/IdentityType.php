<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Monitorings\Identity;

class IdentityType extends GuidType
{
    public const TYPE_NAME = 'identity_type';

    public function getName(): string
    {
        return self::TYPE_NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return Identity::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Identity) {
            $value = $value->toString();
        }

        return $value;
    }
}
