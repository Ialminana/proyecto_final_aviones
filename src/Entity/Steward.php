<?php

namespace App\Entity;


use App\Repository\StewardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StewardRepository::class)]
class Steward extends Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $air_crew_id = null;

    #[ORM\Column]
    private ?int $flight = null;

    #[ORM\ManyToOne(inversedBy: 'stewards')]
    private ?Flight $flight_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAirCrewId(): ?int
    {
        return $this->air_crew_id;
    }

    public function setAirCrewId(int $air_crew_id): static
    {
        $this->air_crew_id = $air_crew_id;

        return $this;
    }

    public function getFlightId(): ?Flight
    {
        return $this->flight_id;
    }

    public function setFlightId(?Flight $flight_id): static
    {
        $this->flight_id = $flight_id;

        return $this;
    }

   
}
