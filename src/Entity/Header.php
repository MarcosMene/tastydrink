<?php

namespace App\Entity;

use App\Repository\HeaderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HeaderRepository::class)]
class Header
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank]
  #[Assert\Length(
    min: 10,
    max: 30,
    minMessage: 'The title must be at least {{ limit }} characters long.',
    maxMessage: 'The title must be no longer than {{ limit }} characters.'
  )]
  private ?string $title = null;

  #[ORM\Column(type: Types::TEXT)]
  #[Assert\NotBlank]
  #[Assert\Length(
    min: 10,
    max: 70,
    minMessage: 'The title must be at least {{ limit }} characters long.',
    maxMessage: 'The title must be no longer than {{ limit }} characters.'
  )]
  private ?string $content = null;

  #[ORM\Column(length: 255)]
  #[Assert\NotBlank]
  #[Assert\Length(
    min: 3,
    max: 20,
    minMessage: 'The title of button must be at least {{ limit }} characters long.',
    maxMessage: 'The title of button must be no longer than {{ limit }} characters.'
  )]
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
