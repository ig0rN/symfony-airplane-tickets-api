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

    public function getResponseData(string $ticketUuid): array
    {
        $ticket = $this->ticketProvider->getFlight($ticketUuid);

        $ticket->setCanceled(true);

        $this->entityManager->flush();

        return [
            'success' => true,
        ];
    }
}
