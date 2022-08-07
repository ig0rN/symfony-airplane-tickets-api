<?php

namespace App\Feature\Ticket\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ChangeSeatRequest
{
    /**
     * @Assert\NotBlank
     */
    private int $seatNumber;

    public function getSeatNumber(): int
    {
        return $this->seatNumber;
    }

    public function setSeatNumber(int $seatNumber): ChangeSeatRequest
    {
        $this->seatNumber = $seatNumber;

        return $this;
    }
}
