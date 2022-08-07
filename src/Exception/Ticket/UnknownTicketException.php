<?php

namespace App\Exception\Ticket;

use App\Exception\AppException;
use Symfony\Component\HttpFoundation\Response;

class UnknownTicketException extends AppException
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_NOT_FOUND);
    }
}
