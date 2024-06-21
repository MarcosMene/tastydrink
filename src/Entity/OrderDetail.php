<?php

namespace App\Entity;

use App\Repository\OrderDetailRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderDetailRepository::class)]
class OrderDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    private ?Order $myOrder = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 3,
        max: 40,
        minMessage: 'The name of the product must be at least {{ limit }} characters long.',
        maxMessage: 'The name of the product must be no longer than {{ limit }} characters.'
    )]
    private ?string $productName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $productIllustration = null;

    #[ORM\Column]
    #[Assert\Positive]
    #[Assert\Range(
        min: 1,
        max: 20,
        notInRangeMessage: "The minimum you can buy is {{ min }} and the maximum is {{ max }}."
    )]
    private ?int $productQuantity = null;

    #[ORM\Column]
    #[Assert\Positive]
    #[Assert\Range(
        min: 10,
        max: 100,
        notInRangeMessage: "Price must be from {{ min }} to {{ max }}."
    )]
    private ?float $productPrice = null;

    #[ORM\Column]
    private ?float $productTva = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMyOrder(): ?Order
    {
        return $this->myOrder;
    }

    public function setMyOrder(?Order $myOrder): static
    {
        $this->myOrder = $myOrder;
        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): static
    {
        $this->productName = $productName;
        return $this;
    }

    public function getProductIllustration(): ?string
    {
        return $this->productIllustration;
    }

    public function setProductIllustration(string $productIllustration): static
    {
        $this->productIllustration = $productIllustration;
        return $this;
    }

    public function getProductQuantity(): ?int
    {
        return $this->productQuantity;
    }

    public function setProductQuantity(int $productQuantity): static
    {
        $this->productQuantity = $productQuantity;
        return $this;
    }

    public function getProductPriceWt()
    {
        $coeff = 1 + ($this->productTva / 100);
        return $coeff * $this->productPrice;
    }

    public function getProductPrice(): ?float
    {
        return $this->productPrice;
    }

    public function setProductPrice(float $productPrice): static
    {
        $this->productPrice = $productPrice;
        return $this;
    }

    public function getProductTva(): ?float
    {
        return $this->productTva;
    }

    public function setProductTva(float $productTva): static
    {
        $this->productTva = $productTva;
        return $this;
    }
}
