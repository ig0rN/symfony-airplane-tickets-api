<?php

namespace App\Exception;

use Exception;
use Throwable;

/**
 * Main exception that should be extended by every custom exception
 * in order to have clear difference between custom and framework/php exceptions.
 */
abstract class AppException extends Exception
{
    public function __construct(string $message, int $code, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string
    {
        return __CLASS__.": [{$this->code}]: {$this->message}\n";
    }
}
