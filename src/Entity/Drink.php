<?php

namespace App\Entity;

use App\Repository\DrinkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DrinkRepository::class)]

//to not repeat the name of menu drink
#[UniqueEntity('name')]

class Drink
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank]
  private ?string $name = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank]
  private ?string $description = null;

  #[ORM\Column]
  #[Assert\NotBlank]
  private ?float $price = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank]
  private ?string $illustration = null;

  #[ORM\ManyToOne(inversedBy: 'drinks')]
  #[ORM\JoinColumn(nullable: true)]
  private ?DrinkCategory $drinkcategory = null;

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

  public function getDescription(): ?string
  {
    return $this->description;
  }

  public function setDescription(string $description): static
  {
    $this->description = $description;

    return $this;
  }

  public function getPrice(): ?float
  {
    return $this->price;
  }

  public function setPrice(float $price): static
  {
    $this->price = $price;

    return $this;
  }

  public function getIllustration(): ?string
  {
    return $this->illustration;
  }

  public function setIllustration(string $illustration): static
  {
    $this->illustration = $illustration;

    return $this;
  }

  public function getDrinkcategory(): ?DrinkCategory
  {
    return $this->drinkcategory;
  }

  public function setDrinkcategory(?DrinkCategory $drinkcategory): static
  {
    $this->drinkcategory = $drinkcategory;

    return $this;
  }
}
