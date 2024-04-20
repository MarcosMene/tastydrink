<?php

namespace App\Entity;

use App\Repository\CarrierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CarrierRepository::class)]
class Carrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 40,
        minMessage: 'The name of company must be at least {{ limit }} characters long.',
        maxMessage: 'The name of company must be no longer than {{ limit }} characters.'
    )]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 20,
        max: 50,
        minMessage: 'The description of the carrier must be at least {{ limit }} characters long.',
        maxMessage: 'The description of the carrier must be no longer than {{ limit }} characters.'
    )]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Positive]
    #[Assert\LessThanOrEqual(1000, message: 'The maximum price for transportation is ${{ compared_value }}.')]
    #[Assert\GreaterThanOrEqual(5, message: 'The mininum price for transportation is ${{ compared_value }}.')]
    private ?float $price = null;

    public function __toString()
    {
        $price = number_format($this->getPrice(), 2, '.', ',');
        return $this->getName() . '<br/>' . '$ ' . $price;
    }

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
}