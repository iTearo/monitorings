<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\JsonType;
use Domain\Outlet\Domain\Address;

class AddressType extends JsonType
{
    public const TYPE_NAME = 'address_type';

    public function getName(): string
    {
        return self::TYPE_NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $value = parent::convertToPHPValue($value, $platform);

        return new Address(
            $value['building'],
            $value['street'],
            $value['locality']
        );
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Address) {
            $value = [
                'locality' => $value->getLocality(),
                'street' => $value->getStreet(),
                'building' => $value->getBuilding()
            ];
        }

        /** @noinspection JsonEncodingApiUsageInspection */
        $encoded = json_encode($value, JSON_UNESCAPED_UNICODE);

        if (json_last_error() !== JSON_ERROR_NONE) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw ConversionException::conversionFailedSerialization($value, 'json', json_last_error_msg());
        }

        return $encoded;
    }
}
