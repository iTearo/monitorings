<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Domain\File\Domain\FileIdentity;

class FileIdentityType extends GuidType
{
    public const TYPE_NAME = 'file_identity_type';

    public function getName(): string
    {
        return self::TYPE_NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?FileIdentity
    {
        return $value === null ? null : FileIdentity::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof FileIdentity ? (string) $value : $value;
    }
}
