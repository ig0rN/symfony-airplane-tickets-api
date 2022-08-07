<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class UnauthorizedException extends AppException
{
    public function __construct()
    {
        parent::__construct('Unauthorized access!', Response::HTTP_UNAUTHORIZED);
    }
}
