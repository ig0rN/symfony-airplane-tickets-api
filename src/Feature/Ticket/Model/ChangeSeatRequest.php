<?php

namespace App\Feature\Ticket\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ChangeSeatRequest extends AbstractModel
{
    /**
     * @Assert\NotBlank
     */
    private string $ticketId;

    /**
     * @Assert\NotBlank
     */
    private int $seatNumber;

    public function getTicketId(): string
    {
        return $this->ticketId;
    }

    public function setTicketId(string $ticketId): self
    {
        $this->ticketId = $ticketId;

        return $this;
    }

    public function getSeatNumber(): int
    {
        return $this->seatNumber;
    }

    public function setSeatNumber(int $seatNumber): self
    {
        $this->seatNumber = $seatNumber;

        return $this;
    }
}
