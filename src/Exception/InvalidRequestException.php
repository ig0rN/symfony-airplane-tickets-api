<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class InvalidRequestException extends AppException
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_BAD_REQUEST);
    }
}
