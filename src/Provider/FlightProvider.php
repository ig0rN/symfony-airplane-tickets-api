<?php

namespace App\Provider;

use App\Entity\Flight;
use App\Exception\Flight\UnknownFlightException;
use App\Repository\FlightRepository;

class FlightProvider
{
    public function __construct(
        private readonly FlightRepository $flightRepository,
    ) {
    }

    public function getFlight(string $flightUuid): Flight
    {
        $flight = $this->flightRepository->findOneBy(['uuid' => $flightUuid]);

        if (null === $flight) {
            throw new UnknownFlightException(sprintf('Flight with ID: [%s] not found!', $flightUuid));
        }

        return $flight;
    }
}
