<?php

namespace App\Entity;

use App\Repository\FoodCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodCategoryRepository::class)]
class FoodCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Food::class, mappedBy: 'foodcategory', orphanRemoval: true)]
    private Collection $food;

    #[ORM\Column(nullable: true)]
    private ?int $orderAppear = null;

    public function __construct()
    {
        $this->food = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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

    /**
     * @return Collection<int, Food>
     */
    public function getFood(): Collection
    {
        return $this->food;
    }

    public function addFood(Food $food): static
    {
        if (!$this->food->contains($food)) {
            $this->food->add($food);
            $food->setFoodcategory($this);
        }

        return $this;
    }

    public function removeFood(Food $food): static
    {
        if ($this->food->removeElement($food)) {
            // set the owning side to null (unless already changed)
            if ($food->getFoodcategory() === $this) {
                $food->setFoodcategory(null);
            }
        }

        return $this;
    }

    public function getOrderAppear(): ?int
    {
        return $this->orderAppear;
    }

    public function setOrderAppear(?int $orderAppear): static
    {
        $this->orderAppear = $orderAppear;

        return $this;
    }
}
