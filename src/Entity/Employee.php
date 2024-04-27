<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Assert\Length(
    min: 3,
    max: 60,
    minMessage: 'First name must be at least {{ limit }} characters long',
    maxMessage: 'First name must be no longer than {{ limit }} characters'
  )]
  private ?string $firstName = null;

  #[ORM\Column(length: 255)]
  #[Assert\Length(
    min: 5,
    max: 60,
    minMessage: 'Last name must be at least {{ limit }} characters long',
    maxMessage: 'Last name must be no longer than {{ limit }} characters'
  )]
  private ?string $lastName = null;

  #[ORM\Column(length: 255, nullable: true)]
  private string $position;



  #[ORM\Column(length: 255)]
  private ?string $email = null;

  #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
  #[Assert\GreaterThanOrEqual('today', message: 'The join date must be today or ten days after today.')]
  private ?\DateTimeInterface $joinDate = null;

  #[ORM\ManyToOne(inversedBy: 'employees')]
  #[ORM\JoinColumn(nullable: false)]
  private ?Team $team = null;

  #[ORM\Column(length: 255)]
  private ?string $illustration = null;

  #[ORM\Column(nullable: true)]
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
