<?php

namespace App\DataFixtures;

use App\Entity\Aircraft;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AircraftFixtures extends Fixture
{
    private array $data = [
        [
            'manufacturer' => 'Airbus',
            'model' => 'A 320-200',
            'seat-number' => 192,
            'ref' => 'AB-A-320-200',
        ],
        [
            'manufacturer' => 'Boeing',
            'model' => '747-8',
            'seat-number' => 410,
            'ref' => 'BOE-747-8',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->data as $aircraft) {
            $a = (new Aircraft())
                ->setManufacturer($aircraft['manufacturer'])
                ->setModel($aircraft['model'])
                ->setSeatNumber($aircraft['seat-number'])
            ;

            $this->addReference($aircraft['ref'], $a);

            $manager->persist($a);
        }

        $manager->flush();
    }
}
