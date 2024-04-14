<?php

namespace App\Entity;

use App\Repository\DepartamentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartamentRepository::class)]
class Departament
{

    // public function __construct()
    // {
    //     $this->setDefault();
    // }

    // public function setDefault()
    // {
    //     $this->name = 'no job';
    // }


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}