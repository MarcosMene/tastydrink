<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]

//to not repeat the employee's email
#[UniqueEntity('email')]
class Employee
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank]
  private ?string $firstName = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank]
  private ?string $lastName = null;

  #[ORM\Column(length: 255, nullable: true)]
  #[Assert\NotBlank]
  private string $position;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank]
  private ?string $email = null;

  #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
  #[Assert\NotBlank]
  private ?\DateTimeInterface $joinDate = null;

  #[ORM\ManyToOne(inversedBy: 'employees')]
  #[ORM\JoinColumn(nullable: false)]
  private ?Team $team = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank]
  private ?string $illustration = null;

  #[ORM\Column(nullable: true)]
  #[Assert\NotBlank]
  private ?int $orderAppear = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getFirstName(): ?string
  {
    return $this->firstName;
  }

  public function setFirstName(string $firstName): static
  {
    $this->firstName = $firstName;

    return $this;
  }

  public function getLastName(): ?string
  {
    return $this->lastName;
  }

  public function setLastName(string $lastName): static
  {
    $this->lastName = $lastName;

    return $this;
  }

  public function getPosition(): ?string
  {
    return $this->position;
  }

  public function setPosition(string $position): static
  {
    $this->position = $position;

    return $this;
  }

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(string $email): static
  {
    $this->email = $email;

    return $this;
  }

  public function getJoinDate(): ?\DateTimeInterface
  {
    return $this->joinDate;
  }

  public function setJoinDate(\DateTimeInterface $joinDate): static
  {
    $this->joinDate = $joinDate;

    return $this;
  }

  public function getTeam(): ?Team
  {
    return $this->team;
  }

  public function setTeam(?Team $team): static
  {
    $this->team = $team;

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
