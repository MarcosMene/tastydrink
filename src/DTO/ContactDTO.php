<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO
{

  #[Assert\NotBlank]
  #[Assert\Length(min: 3, max: 30)]
  public string $firstName = '';

  #[Assert\NotBlank]
  #[Assert\Length(min: 3, max: 30)]
  public string $lastName = '';

  #[Assert\NotBlank]
  #[Assert\Email]
  public string $email = '';

  #[Assert\NotBlank]
  #[Assert\Length(min: 3, max: 50)]
  public string $subject = '';

  #[Assert\NotBlank]
  #[Assert\Length(min: 10, max: 400)]
  public string $message = '';
}
