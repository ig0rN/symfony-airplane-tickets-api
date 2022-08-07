<?php

namespace App\Entity;

use App\Repository\FlightRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: FlightRepository::class)]
class Flight
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 36, unique: true)]
    private string $uuid;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Aircraft $aircraft = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $departureTime = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Airport $sourceAirport = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Airport $destinationAirport = null;

    #[ORM\OneToMany(mappedBy: 'flight', targetEntity: Ticket::class)]
    private Collection $tickets;

    public function __construct()
    {
        $this->uuid = Uuid::uuid1();
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getAircraft(): ?Aircraft
    {
        return $this->aircraft;
    }

    public function setAircraft(Aircraft $aircraft): self
    {
        $this->aircraft = $aircraft;

        return $this;
    }

    public function getDepartureTime(): ?\DateTimeImmutable
    {
        return $this->departureTime;
    }

    public function setDepartureTime(\DateTimeImmutable $departureTime): self
    {
        $this->departureTime = $departureTime;

        return $this;
    }

    public function getSourceAirport(): ?Airport
    {
        return $this->sourceAirport;
    }

    public function setSourceAirport(Airport $sourceAirport): self
    {
        $this->sourceAirport = $sourceAirport;

        return $this;
    }

    public function getDestinationAirport(): ?Airport
    {
        return $this->destinationAirport;
    }

    public function setDestinationAirport(Airport $destinationAirport): self
    {
        $this->destinationAirport = $destinationAirport;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setFlight($this);
        }

        return $this;
    }

//    public function removeTicket(Ticket $ticket): self
//    {
//        if ($this->tickets->removeElement($ticket)) {
//            // set the owning side to null (unless already changed)
//            if ($ticket->getFlight() === $this) {
//                $ticket->setFlight(null);
//            }
//        }
//
//        return $this;
//    }
}
