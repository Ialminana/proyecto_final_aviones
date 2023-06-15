<?php

namespace App\Entity;

use App\Repository\FlightRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlightRepository::class)]
class Flight
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\Column(length: 255)]
    private ?string $departsFrom = null;

    #[ORM\Column(length: 255)]
    private ?string $arrivesTo = null;

    #[ORM\OneToMany(mappedBy: 'flight', targetEntity: Steward::class)]
    private Collection $stewards;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Captain $captain = null;

    #[ORM\ManyToMany(targetEntity: Passenger::class, mappedBy: 'flight')]
    private Collection $passengers;

    public function __construct()
    {
        $this->stewards = new ArrayCollection();
        $this->passengers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getDepartsFrom(): ?string
    {
        return $this->departsFrom;
    }

    public function setDepartsFrom(string $departsFrom): static
    {
        $this->departsFrom = $departsFrom;

        return $this;
    }

    public function getArrivesTo(): ?string
    {
        return $this->arrivesTo;
    }

    public function setArrivesTo(string $arrivesTo): static
    {
        $this->arrivesTo = $arrivesTo;

        return $this;
    }

    /**
     * @return Collection<int, Steward>
     */
    public function getStewards(): Collection
    {
        return $this->stewards;
    }

    public function addSteward(Steward $steward): static
    {
        if (!$this->stewards->contains($steward)) {
            $this->stewards->add($steward);
            $steward->setFlight($this);
        }

        return $this;
    }

    public function removeSteward(Steward $steward): static
    {
        if ($this->stewards->removeElement($steward)) {
            // set the owning side to null (unless already changed)
            if ($steward->getFlight() === $this) {
                $steward->setFlight(null);
            }
        }

        return $this;
    }

    public function getCaptain(): ?Captain
    {
        return $this->captain;
    }

    public function setCaptain(?Captain $captain): static
    {
        $this->captain = $captain;

        return $this;
    }

    /**
     * @return Collection<int, Passenger>
     */
    public function getPassengers(): Collection
    {
        return $this->passengers;
    }

    public function addPassenger(Passenger $passenger): static
    {
        if (!$this->passengers->contains($passenger)) {
            $this->passengers->add($passenger);
           
        }

        return $this;
    }

    public function removePassenger(Passenger $passenger): static
    {
        if ($this->passengers->removeElement($passenger)) {
            
        }

        return $this;
    }
}
