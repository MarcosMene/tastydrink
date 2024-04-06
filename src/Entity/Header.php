<?php

namespace App\Entity;

use App\Repository\HeaderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HeaderRepository::class)]
class Header
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $buttonTitle = null;

    #[ORM\Column(length: 255)]
    private ?string $buttonLink = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getButtonTitle(): ?string
    {
        return $this->buttonTitle;
    }

    public function setButtonTitle(string $buttonTitle): static
    {
        $this->buttonTitle = $buttonTitle;

        return $this;
    }

    public function getButtonLink(): ?string
    {
        return $this->buttonLink;
    }

    public function setButtonLink(string $buttonLink): static
    {
        $this->buttonLink = $buttonLink;

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
}
