<?php

declare(strict_types=1);

namespace Monitorings\File\Domain\Exceptions;

use RuntimeException;

class InvalidMimeTypeException extends RuntimeException
{
    public function __construct(string $mimeType)
    {
        $message = sprintf('Invalid mime type: %s', $mimeType);
        parent::__construct($message);
    }
}
