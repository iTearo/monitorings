<?php

declare(strict_types=1);

namespace Domain\File\Domain\Exceptions;

use RuntimeException;

class InvalidExtensionException extends RuntimeException
{
    public function __construct(string $extension)
    {
        $message = sprintf('Invalid file extension: %s', $extension);
        parent::__construct($message);
    }
}
