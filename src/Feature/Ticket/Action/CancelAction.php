<?php

namespace App\Feature\Ticket\Action;

use App\Provider\TicketProvider;
use Doctrine\ORM\EntityManagerInterface;

class CancelAction
{
    public function __construct(
        private readonly TicketProvider $ticketProvider,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function handleRequest(string $ticketUuid): array
    {
        $ticket = $this->ticketProvider->getTicket($ticketUuid);

        $ticket->setCanceled(true);

        $this->entityManager->flush();

        return [
            'success' => true,
        ];
    }
}
