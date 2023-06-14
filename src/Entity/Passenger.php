<?php

namespace App\Entity;

use App\Repository\PassengerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PassengerRepository::class)]
class Passenger 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $seat = null;

    #[ORM\ManyToMany(targetEntity: Flight::class, inversedBy: 'passengers')]
    private Collection $flight;

    public function __construct()
    {
        $this->flight = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeat(): ?int
    {
        return $this->seat;
    }

    public function setSeat(int $seat): static
    {
        $this->seat = $seat;

        return $this;
    }

    /**
     * @return Collection<int, Flight>
     */
    public function getFlight(): Collection
    {
        return $this->flight;
    }

    public function addFlight(Flight $flight): static
    {
        if (!$this->flight->contains($flight)) {
            $this->flight->add($flight);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): static
    {
        $this->flight->removeElement($flight);

        return $this;
    }
}
