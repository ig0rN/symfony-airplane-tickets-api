<?php

namespace App\Feature\Ticket\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CreateRequest
{
    /**
     * @Assert\NotBlank
     */
    private string $flightId;

    /**
     * @Assert\NotBlank
     */
    private string $passport;

    public function getFlightId(): string
    {
        return $this->flightId;
    }

    public function setFlightId(string $flightId): CreateRequest
    {
        $this->flightId = $flightId;

        return $this;
    }

    public function getPassport(): string
    {
        return $this->passport;
    }

    public function setPassport(string $passport): CreateRequest
    {
        $this->passport = $passport;

        return $this;
    }
}
