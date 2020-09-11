<?php

declare(strict_types=1);

namespace Monitorings\File\Domain;

class FileStatus
{
    public const PROCESSING = 1;
    public const UPLOADED = 2;

    public const LIST = [
        self::PROCESSING,
        self::UPLOADED,
    ];

    public static function isValid(int $status): bool
    {
        return \in_array($status, self::LIST, true);
    }
}
