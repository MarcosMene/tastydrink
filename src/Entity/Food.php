<?php

namespace App\Entity;

use App\Repository\FoodRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FoodRepository::class)]
class Food
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank]
  private ?string $name = null;

  #[ORM\Column(type: Types::TEXT)]
  #[Assert\NotBlank]
  private ?string $description = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank]
  private ?string $illustration = null;

  #[ORM\ManyToOne(inversedBy: 'food')]
  #[ORM\JoinColumn(nullable: true)]
  private ?FoodCategory $foodcategory = null;

  #[ORM\Column]
  #[Assert\NotBlank]
  private ?float $price = null;

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

  public function getIllustration(): ?string
  {
    return $this->illustration;
  }

  public function setIllustration(string $illustration): static
  {
    $this->illustration = $illustration;

    return $this;
  }

  public function getFoodcategory(): ?FoodCategory
  {
    return $this->foodcategory;
  }

  public function setFoodcategory(?FoodCategory $foodcategory): static
  {
    $this->foodcategory = $foodcategory;

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
}
