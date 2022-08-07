<?php

namespace App\Feature\Ticket\Service;

use App\Entity\Flight;
use App\Entity\Ticket;
use App\Feature\Ticket\DTO\CreateRequest;
use App\Provider\FlightProvider;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;

class TicketFactory
{
    public function __construct(
        private readonly FlightProvider $flightProvider,
        private readonly TicketRepository $ticketRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function make(CreateRequest $createRequest): Ticket
    {
        $flight = $this->flightProvider->getFlight($createRequest->getFlightId());

        $ticket = (new Ticket())
            ->setFlight($flight)
            ->setSeatNumber(
                $this->getSeatNumber($flight)
            )
            ->setPassport($createRequest->getPassport())
        ;

        $this->entityManager->persist($ticket);
        $this->entityManager->flush();

        return $ticket;
    }

    private function getSeatNumber(Flight $flight): int
    {
        $reservedSeats = $this->ticketRepository->getReservedSeats($flight);

        do {
            $seatNumber = mt_rand(1, $flight->getAircraft()->getSeatNumber());
        } while (in_array($seatNumber, $reservedSeats));

        return $seatNumber;
    }
}
