<?php

declare(strict_types=1);

namespace App\Exception;

class RequestValidationException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Request validation failed');
    }
}
