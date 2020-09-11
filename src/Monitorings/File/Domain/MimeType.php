<?php

declare(strict_types=1);

namespace Monitorings\File\Domain;

use Monitorings\File\Domain\Exceptions\InvalidMimeTypeException;

final class MimeType
{
    protected const MIME_TYPE_EXTENSION_MAP = [
        'image/jpeg' => 'jpg',
        'image/jpg' => 'jpg',
        'image/png' => 'png',
    ];

    public const ALLOWED_MIME_TYPES = [
        'image/jpeg',
        'image/jpg',
        'image/png',
    ];

    public static function isAllowed(string $mimeType): bool
    {
        return in_array($mimeType, self::ALLOWED_MIME_TYPES, true);
    }

    public static function getExtension(string $mimeType): ?string
    {
        if (!array_key_exists($mimeType, self::MIME_TYPE_EXTENSION_MAP)) {
            throw new InvalidMimeTypeException($mimeType);
        }

        return self::MIME_TYPE_EXTENSION_MAP[$mimeType];
    }

    public static function getMimeType(string $extension): string
    {
        if (!in_array($extension, self::MIME_TYPE_EXTENSION_MAP, true)) {
            throw new InvalidMimeTypeException($extension);
        }

        return array_search($extension, self::MIME_TYPE_EXTENSION_MAP, true);
    }
}
