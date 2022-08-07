<?php

namespace App\Validator;

use App\Exception\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SysValidator
{
    public function __construct(
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function validate($object): void
    {
        $violations = $this->validator->validate($object);

        if ($violations->count() > 0) {
            $errors = [];

            foreach ($violations as $violation) {
                $errors[] = [
                    'property' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                ];
            }

            throw new ValidationException($errors);
        }
    }
}
