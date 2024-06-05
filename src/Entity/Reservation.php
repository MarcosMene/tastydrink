<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull(message: 'First name should not be blank')]
    #[Assert\Length(
        min: 3,
        max: 25,
        minMessage: 'Your first name must be at least {{ limit }} characters long',
        maxMessage: 'Your first name cannot be longer than {{ limit }} characters',
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-ZÀ-ÿ\s\-]/',
        message: 'Name should only contain alphabetic characters'
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Last name should not be blank')]
    #[Assert\Length(
        min: 3,
        max: 25,
        minMessage: 'Your last name must be at least {{ limit }} characters long',
        maxMessage: 'Your last name cannot be longer than {{ limit }} characters',
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-ZÀ-ÿ]/',
        message: 'Name should only contain alphabetic characters'
    )]
    private ?string $lastname = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Telephone should not be blank')]
    #[Assert\Length(
        min: 8,
        max: 25,
        minMessage: 'Your telephone must be at least {{ limit }} characters long',
        maxMessage: 'Your telephone cannot be longer than {{ limit }} characters',
    )]
    #[Assert\Regex(
        pattern: '/^(?:(?:\+|00)1|0)[1-9](?:\d{2}){4}$/',
        message: 'The format of the telephone is not correct.'
    )]
    private ?string $telephone = null;

    #[ORM\Column]
    #[Assert\Positive]
    private ?int $numberOfPeople = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: 'You need to choose a day')]
    private ?\DateTimeInterface $reservationDate = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message: 'You need to choose an hour')]
    private ?\DateTimeInterface $reservationTime = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
        min: 15,
        max: 300,
        minMessage: 'Your message must be at least {{ limit }} characters long',
        maxMessage: 'Your message cannot be longer than {{ limit }} characters',
    )]
    #[Assert\Regex(
        pattern: '/^[0-9a-zA-ZÀ-ÿ\s?!.,:;()"\'\d]{15,300}$/',
        message: 'Comments should only contain alphabetic characters and ?!.:;()'
    )]
    private ?string $comments = null;

    #[ORM\Column(nullable: true)]
    private ?bool $cancelReservation = false;

    public function __toString()
    {
        return $this->firstname;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberOfPeople(): ?int
    {
        return $this->numberOfPeople;
    }

    public function setNumberOfPeople(int $numberOfPeople): static
    {
        $this->numberOfPeople = $numberOfPeople;

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

    public function getReservationDate(): ?\DateTimeInterface
    {
        return $this->reservationDate;
    }

    public function setReservationDate(\DateTimeInterface $reservationDate): static
    {
        $this->reservationDate = $reservationDate;

        return $this;
    }

    public function getReservationTime(): ?\DateTimeInterface
    {
        return $this->reservationTime;
    }

    public function setReservationTime(\DateTimeInterface $reservationTime): static
    {
        $this->reservationTime = $reservationTime;

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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): static
    {
        $this->comments = $comments;

        return $this;
    }

    public function isCancelReservation(): ?bool
    {
        return $this->cancelReservation;
    }

    public function setCancelReservation(?bool $cancelReservation): static
    {
        $this->cancelReservation = $cancelReservation;

        return $this;
    }
}
