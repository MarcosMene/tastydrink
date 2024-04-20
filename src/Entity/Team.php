<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $nameTeam = null;

    #[ORM\OneToMany(targetEntity: Employee::class, mappedBy: 'team', orphanRemoval: true)]
    private Collection $employees;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNameTeam() ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTeam(): ?string
    {
        return $this->nameTeam;
    }

    public function setNameTeam(string $nameTeam): static
    {
        $this->nameTeam = $nameTeam;

        return $this;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): static
    {
        if (!$this->employees->contains($employee)) {
            $this->employees->add($employee);
            $employee->setTeam($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): static
    {
        if ($this->employees->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getTeam() === $this) {
                $employee->setTeam(null);
            }
        }

        return $this;
    }
}
