<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Flight $flight = null;

    #[ORM\Column(length: 36)]
    private string $uuid;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $seatNumber = null;

    #[ORM\Column(length: 20)]
    private ?string $passportId = null;

    public function __construct()
    {
        $this->uuid = Uuid::uuid1();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    public function setFlight(Flight $flight): self
    {
        $this->flight = $flight;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getSeatNumber(): ?int
    {
        return $this->seatNumber;
    }

    public function setSeatNumber(int $seatNumber): self
    {
        $this->seatNumber = $seatNumber;

        return $this;
    }

    public function getPassportId(): ?string
    {
        return $this->passportId;
    }

    public function setPassportId(string $passportId): self
    {
        $this->passportId = $passportId;

        return $this;
    }
}