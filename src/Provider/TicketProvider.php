<?php

namespace App\Provider;

use App\Entity\Ticket;
use App\Exception\Ticket\UnknownTicketException;
use App\Repository\TicketRepository;

class TicketProvider
{
    public function __construct(
        private readonly TicketRepository $ticketRepository,
    ) {
    }

    /**
     * @throws UnknownTicketException
     */
    public function getFlight(string $flightUuid): Ticket
    {
        $flight = $this->ticketRepository->findOneBy(['uuid' => $flightUuid]);

        if (null === $flight) {
            throw new UnknownTicketException(sprintf('Ticket with ID: [%s] not found!', $flightUuid));
        }

        return $flight;
    }
}
