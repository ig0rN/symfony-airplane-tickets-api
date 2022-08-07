<?php

namespace App\Feature\Ticket\Action;

use App\Feature\Ticket\DTO\CreateRequest;
use App\Feature\Ticket\Service\TicketFactory;

class CreateAction
{
    public function __construct(
        private readonly TicketFactory $ticketFactory,
    ) {
    }

    public function getResponseData(CreateRequest $createRequest): array
    {
        $ticket = $this->ticketFactory->make($createRequest);

        $flight = $ticket->getFlight();

        $departureTime = $flight->getDepartureTime();
        $sourceAirport = $flight->getSourceAirport();
        $destinationAirport = $flight->getDestinationAirport();

        return [
            'flightNumber' => $flight->getUuid(),
            'departure' => [
                'date' => $departureTime->format('d-m-Y'),
                'time' => $departureTime->format('H:i'),
            ],
            'airports' => [
                'source' => [
                    'name' => $sourceAirport->getName(),
                    'icao' => $sourceAirport->getICAO(),
                    'iat' => $sourceAirport->getIAT(),
                    'city' => $sourceAirport->getCity(),
                    'county' => $sourceAirport->getCountry(),
                ],
                'destination' => [
                    'name' => $destinationAirport->getName(),
                    'icao' => $destinationAirport->getICAO(),
                    'iat' => $destinationAirport->getIAT(),
                    'city' => $destinationAirport->getCity(),
                    'county' => $destinationAirport->getCountry(),
                ],
            ],
            'aircraft' => [
                'manufacturer' => $flight->getAircraft()->getManufacturer(),
                'model' => $flight->getAircraft()->getModel(),
            ],
            'ticketNumber' => $ticket->getUuid(),
            'seatNumber' => $ticket->getSeatNumber(),
            'passport' => $ticket->getPassport(),
        ];
    }
}
