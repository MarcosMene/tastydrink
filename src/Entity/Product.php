<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 3,
        max: 40,
        minMessage: 'The name of the product must be at least {{ limit }} characters long.',
        maxMessage: 'The name of the product must be no longer than {{ limit }} characters.'
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 3,
        max: 40,
        minMessage: 'The subtitle of the product must be at least {{ limit }} characters long.',
        maxMessage: 'The subtitle of the product must be no longer than {{ limit }} characters.'
    )]
    private ?string $subtitle = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(
        min: 20,
        max: 200,
        minMessage: 'The description of the product must be at least {{ limit }} characters long.',
        maxMessage: 'The description of the product must be no longer than {{ limit }} characters.'
    )]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\Positive]
    #[Assert\LessThanOrEqual(100, message: 'The maximum price for this product is ${{ compared_value }}.')]
    #[Assert\GreaterThanOrEqual(10, message: 'The mininum price for this product is ${{ compared_value }}.')]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column]
    private ?float $tva = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isSuggestion = null;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

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

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): static
    {
        $this->subtitle = $subtitle;

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

    public function getPriceWt()
    {
        $coeff = 1 + ($this->tva / 100);
        return $coeff * $this->price;
    }


    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): static
    {
        $this->tva = $tva;

        return $this;
    }

    public function isIsSuggestion(): ?bool
    {
        return $this->isSuggestion;
    }

    public function setIsSuggestion(?bool $isSuggestion): static
    {
        $this->isSuggestion = $isSuggestion;

        return $this;
    }
}
