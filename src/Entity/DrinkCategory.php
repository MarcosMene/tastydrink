<?php

namespace App\Entity;

use App\Repository\DrinkCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DrinkCategoryRepository::class)]
class DrinkCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Drink::class, mappedBy: 'drinkcategory', orphanRemoval: true)]
    private Collection $drinks;

    public function __construct()
    {
        $this->drinks = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName() ?? '';
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
     * @return Collection<int, Drink>
     */
    public function getDrinks(): Collection
    {
        return $this->drinks;
    }

    public function addDrink(Drink $drink): static
    {
        if (!$this->drinks->contains($drink)) {
            $this->drinks->add($drink);
            $drink->setDrinkcategory($this);
        }

        return $this;
    }

    public function removeDrink(Drink $drink): static
    {
        if ($this->drinks->removeElement($drink)) {
            // set the owning side to null (unless already changed)
            if ($drink->getDrinkcategory() === $this) {
                $drink->setDrinkcategory(null);
            }
        }

        return $this;
    }
}
