<?php

namespace App\DataFixtures;

use App\Entity\Ticket;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TicketFixtures extends Fixture implements DependentFixtureInterface
{
    private array $data = [
        [
            'flight-ref' => 'AB-SRB-BG-ESP-BCN',
            'passport-id' => '005616606',
            'seat-number' => 1,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->data as $ticket) {
            $t = (new Ticket())
                ->setFlight($this->getReference($ticket['flight-ref']))
                ->setPassportId($ticket['passport-id'])
                ->setSeatNumber($ticket['seat-number'])
            ;

            $manager->persist($t);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            FlightFixtures::class,
        ];
    }
}
