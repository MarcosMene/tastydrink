<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingsRepository::class)]
class Settings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $maxSeats = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaxSeats(): ?int
    {
        return $this->maxSeats;
    }

    public function setMaxSeats(int $maxSeats): static
    {
        $this->maxSeats = $maxSeats;
        return $this;
    }
}
