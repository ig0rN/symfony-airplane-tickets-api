<?php

namespace App\Exception\Flight;

use App\Exception\AppException;
use Symfony\Component\HttpFoundation\Response;

class FullyBookedFlightException extends AppException
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_NOT_FOUND);
    }
}
