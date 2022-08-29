<?php

namespace App\Feature\Ticket\Action;

use App\Entity\Flight;
use App\Exception\Ticket\UnavailableSeatException;
use App\Feature\Ticket\Interface\ActionInterface;
use App\Feature\Ticket\Interface\ActionRequestModel;
use App\Provider\TicketProvider;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;

class ChangeSeatAction implements ActionInterface
{
    public function __construct(
        private readonly TicketProvider $ticketProvider,
        private readonly TicketRepository $ticketRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function getResponseFromAction(ActionRequestModel $requestModel): array
    {
        $ticket = $this->ticketProvider->getTicket($requestModel->getTicketId());

        $this->checkSeatNumber($ticket->getFlight(), $requestModel);

        $ticket->setSeatNumber($requestModel->getSeatNumber());

        $this->entityManager->flush();

        return [
            'seatNumber' => $ticket->getSeatNumber(),
        ];
    }

    /**
     * @throws UnavailableSeatException
     */
    private function checkSeatNumber(Flight $flight, ActionRequestModel $requestModel): void
    {
        $chosenSeatNumber = $requestModel->getSeatNumber();

        if ($chosenSeatNumber < 1 || $chosenSeatNumber > $flight->getAircraft()->getSeatNumber()) {
            $message = sprintf(
                'You can pick seats with number that is in range: [%s = %s]',
                1, $flight->getAircraft()->getSeatNumber()
            );

            throw new UnavailableSeatException($message);
        }

        $ticket = $this->ticketRepository->findOneBy([
            'flight' => $flight,
            'seatNumber' => $requestModel->getSeatNumber(),
        ]);

        if (null === $ticket) {
            return;
        }

        throw new UnavailableSeatException(sprintf('Seat with number: [%s] is already taken', $requestModel->getSeatNumber()));
    }
}
