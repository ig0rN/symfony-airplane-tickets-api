<?php

namespace App\Entity;

use App\Repository\AirportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AirportRepository::class)]
class Airport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column(length: 20, unique: true)]
    private ?string $ICAO = null;

    #[ORM\Column(length: 20, unique: true)]
    private ?string $IAT = null;

    #[ORM\Column(length: 40)]
    private ?string $city = null;

    #[ORM\Column(length: 70)]
    private ?string $country = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getICAO(): ?string
    {
        return $this->ICAO;
    }

    public function setICAO(string $ICAO): self
    {
        $this->ICAO = $ICAO;

        return $this;
    }

    public function getIAT(): ?string
    {
        return $this->IAT;
    }

    public function setIAT(string $IAT): self
    {
        $this->IAT = $IAT;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }
}
