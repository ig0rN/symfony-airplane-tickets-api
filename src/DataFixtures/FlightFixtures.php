<?php

namespace App\DataFixtures;

use App\Entity\Flight;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FlightFixtures extends Fixture implements DependentFixtureInterface
{
    private array $data = [
        [
            'aircraft-ref' => 'AB-A-320-200',
            'departure-time' => '16-08-2022 18:10:00',
            'source-airport-ref' => 'SRB-BG',
            'destination-airport-ref' => 'ESP-BCN',
            'ref' => 'AB-SRB-BG-ESP-BCN',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->data as $flight) {
            $f = (new Flight())
                ->setAircraft($this->getReference($flight['aircraft-ref']))
                ->setDepartureTime(
                    \DateTimeImmutable::createFromFormat('d-m-Y H:i:s', $flight['departure-time'])
                )
                ->setSourceAirport($this->getReference($flight['source-airport-ref']))
                ->setDestinationAirport($this->getReference($flight['destination-airport-ref']))
            ;

            $this->addReference($flight['ref'], $f);

            $manager->persist($f);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AircraftFixtures::class,
            AirportFixtures::class,
        ];
    }
}
