<?php

namespace App\Entity;
use Doctrine\ORM\Mapping\MappedSuperclass;

use Doctrine\ORM\Mapping as ORM;

#[MappedSuperclass]
class Person
{
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $dni = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }
}
