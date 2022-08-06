<?php

namespace App\DataFixtures;

use App\Entity\Airport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AirportFixtures extends Fixture
{
    private array $data = [
        [
            'name' => 'Nikola Tesla Beograd',
            'ICAO' => 'LYBE',
            'IAT' => 'BEG',
            'city' => 'Belgrade',
            'country' => 'Serbia',
            'ref' => 'SRB-BG',
        ],
        [
            'name' => 'Constantine The Great Nis',
            'ICAO' => 'LYNI',
            'IAT' => 'INI',
            'city' => 'Nis',
            'country' => 'Serbia',
            'ref' => 'SRB-NI',
        ],
        [
            'name' => 'Josep Tarradellas Barcelona-El Prat',
            'ICAO' => 'LEBL',
            'IAT' => 'BCN',
            'city' => 'Barcelona',
            'country' => 'Spain',
            'ref' => 'ESP-BCN',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->data as $airport) {
            $a = (new Airport())
                ->setName($airport['name'])
                ->setICAO($airport['ICAO'])
                ->setIAT($airport['IAT'])
                ->setCity($airport['city'])
                ->setCountry($airport['country'])
            ;

            $this->addReference($airport['ref'], $a);

            $manager->persist($a);
        }

        $manager->flush();
    }
}
