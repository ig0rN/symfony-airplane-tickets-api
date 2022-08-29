<?php

namespace App\Feature\Ticket\Exception;

use App\Exception\AppException;
use Symfony\Component\HttpFoundation\Response;

class UnavailableActionException extends AppException
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_NOT_FOUND);
    }
}
