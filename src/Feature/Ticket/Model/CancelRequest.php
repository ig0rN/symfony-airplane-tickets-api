<?php

namespace App\Feature\Ticket\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CancelRequest extends AbstractModel
{
    /**
     * @Assert\NotBlank
     */
    private string $ticketId;

    public function getTicketId(): string
    {
        return $this->ticketId;
    }

    public function setTicketId(string $ticketId): self
    {
        $this->ticketId = $ticketId;

        return $this;
    }
}
