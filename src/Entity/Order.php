<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column]
    private ?int $state = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Regex('/^[a-zA-ZÀ-ÿ\s\0-9_.-]*$/', message: 'Only numbers and letters and spaces.')]

    #[Assert\Length(
        min: 3,
        max: 40,
        minMessage: 'The name of the carrier must be at least {{ limit }} characters long.',
        maxMessage: 'The name of the carrier must be no longer than {{ limit }} characters.'
    )]
    private ?string $carrierName = null;

    #[ORM\Column]
    #[Assert\Positive]
    #[Assert\Range(
        min: 2,
        max: 20,
        notInRangeMessage: "Price must be from {{ min }} to {{ max }}."
    )]
    private ?float $carrierPrice = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $delivery = null;

    #[ORM\OneToMany(targetEntity: OrderDetail::class, mappedBy: 'myOrder', cascade: ['persist'])]
    private Collection $orderDetails;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $stripe_session_id = null;

    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
    }

    public function getTotalWt()
    {
        $totalTTC = 0;

        $products = $this->getOrderDetails();

        foreach ($products as $product) {
            $coeff = 1 + ($product->getProductTva() / 100);
            $totalTTC += ($product->getProductPrice() * $coeff) * $product->getProductQuantity();
        };
        return   number_format(($totalTTC + $this->getCarrierPrice()), '2', '.', ',');
    }

    public function getTotalTva()
    {
        $totalTva = 0;
        $products = $this->getOrderDetails();

        foreach ($products as $product) {
            $coeff = $product->getProductTva();
            $totalTva += $product->getProductPrice() * $coeff;
        }
        return number_format($totalTva / 100, '2', '.', ',');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): static
    {
        $this->state = $state;
        return $this;
    }

    public function getCarrierName(): ?string
    {
        return $this->carrierName;
    }

    public function setCarrierName(string $carrierName): static
    {
        $this->carrierName = $carrierName;
        return $this;
    }

    public function getCarrierPrice(): ?float
    {
        return $this->carrierPrice;
    }

    public function setCarrierPrice(float $carrierPrice): static
    {
        $this->carrierPrice = $carrierPrice;
        return $this;
    }

    public function getDelivery(): ?string
    {
        return $this->delivery;
    }

    public function setDelivery(string $delivery): static
    {
        $this->delivery = $delivery;
        return $this;
    }

    /**
     * @return Collection<int, OrderDetail>
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetail $orderDetail): static
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->add($orderDetail);
            $orderDetail->setMyOrder($this);
        }
        return $this;
    }

    public function removeOrderDetail(OrderDetail $orderDetail): static
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getMyOrder() === $this) {
                $orderDetail->setMyOrder(null);
            }
        }
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getStripeSessionId(): ?string
    {
        return $this->stripe_session_id;
    }

    public function setStripeSessionId(?string $stripe_session_id): static
    {
        $this->stripe_session_id = $stripe_session_id;
        return $this;
    }
}
