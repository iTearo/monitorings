<?php

declare(strict_types=1);

namespace Monitorings\File\Domain\Exceptions;

use LogicException;

class UnknownFileStatusException extends LogicException
{
    public function __construct(int $status)
    {
        $message = sprintf('Unknown file status: %s', $status);
        parent::__construct($message);
    }
}
