<?php

namespace App\Entity;

use App\Repository\ReviewClientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReviewClientRepository::class)]
class ReviewClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $rate = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Regex('/^[a-zA-ZÀ-ÿ\s\0-9_.-]*$/', message: 'Only numbers and letters and spaces.')]
    #[Assert\Length(
        min: 25,
        max: 200,
        minMessage: 'Comment must be at least {{ limit }} characters long',
        maxMessage: 'Comment must be no longer than {{ limit }} characters'
    )]
    private ?string $comment = null;

    #[ORM\Column]
    private ?bool $isApproved = null;

    #[ORM\ManyToOne(inversedBy: 'reviewClients')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex('/^[a-zA-ZÀ-ÿ\s\0-9_.-]*$/', message: 'Only numbers and letters and spaces.')]
    #[Assert\Length(
        min: 3,
        max: 25,
        minMessage: 'Name must be at least {{ limit }} characters long',
        maxMessage: 'Name must be no longer than {{ limit }} characters'
    )]
    private ?string $firstname = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): static
    {
        $this->rate = $rate;
        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;
        return $this;
    }

    public function isIsApproved(): ?bool
    {
        return $this->isApproved;
    }

    public function setIsApproved(bool $isApproved): static
    {
        $this->isApproved = $isApproved;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;
        return $this;
    }
}
