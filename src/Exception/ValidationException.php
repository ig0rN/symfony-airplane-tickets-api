<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class ValidationException extends AppException
{
    public function __construct(
        private readonly array $data,
    ) {
        parent::__construct('Validation error', Response::HTTP_BAD_REQUEST);
    }

    public function getData(): array
    {
        return $this->data;
    }
}
