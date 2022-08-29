<?php

namespace App\Feature\Ticket\Action;

use App\Feature\Ticket\Interface\ActionInterface;
use App\Feature\Ticket\Interface\ActionRequestModel;
use App\Provider\TicketProvider;
use Doctrine\ORM\EntityManagerInterface;

class CancelAction implements ActionInterface
{
    public function __construct(
        private readonly TicketProvider $ticketProvider,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function getResponseFromAction(ActionRequestModel $requestModel): array
    {
        $ticket = $this->ticketProvider->getTicket($requestModel->getTicketId());

        $ticket->setCanceled(true);

        $this->entityManager->flush();

        return [
            'success' => true,
        ];
    }
}
