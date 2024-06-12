<?php

namespace App\Entity;

use App\Repository\DepartamentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DepartamentRepository::class)]

#[UniqueEntity('name')]
class Departament
{

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Assert\Regex('/^[a-zA-Z0-9_.-]*$/', message: 'Only numbers and letters and spaces.')]
  #[Assert\Length(
    min: 3,
    max: 15,
    minMessage: 'The name of the team must be at least {{ limit }} characters long.',
    maxMessage: 'The name of the team must be no longer than {{ limit }} characters.'
  )]
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
