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

    #[ORM\ManyToOne(inversedBy: 'stewards')]
    private ?Flight $flight = null;

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

    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    public function setFlight(?Flight $flight): static
    {
        $this->flight = $flight;

        return $this;
    }

   
}
