<?php

namespace App\Feature\Ticket\Action;

use App\Entity\Flight;
use App\Exception\Ticket\UnavailableSeatException;
use App\Feature\Ticket\DTO\ChangeSeatRequest;
use App\Provider\TicketProvider;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;

class ChangeSeatAction
{
    public function __construct(
        private readonly TicketProvider $ticketProvider,
        private readonly TicketRepository $ticketRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function handleRequest(string $ticketUuid, ChangeSeatRequest $changeSeatRequest): array
    {
        $ticket = $this->ticketProvider->getTicket($ticketUuid);

        $this->checkSeatNumber($ticket->getFlight(), $changeSeatRequest);

        $ticket->setSeatNumber($changeSeatRequest->getSeatNumber());

        $this->entityManager->flush();

        return [
            'seatNumber' => $ticket->getSeatNumber(),
        ];
    }

    /**
     * @throws UnavailableSeatException
     */
    private function checkSeatNumber(Flight $flight, ChangeSeatRequest $changeSeatRequest): void
    {
        $ticket = $this->ticketRepository->findOneBy([
            'flight' => $flight,
            'seatNumber' => $changeSeatRequest->getSeatNumber(),
        ]);

        if (null === $ticket) {
            return;
        }

        throw new UnavailableSeatException(sprintf('Seat with number: [%s] is already taken', $changeSeatRequest->getSeatNumber()));
    }
}
