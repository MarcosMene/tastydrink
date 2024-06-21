<?php

namespace App\Controller\Admin;

use App\Entity\Header;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints as Assert;

class HeaderCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return Header::class;
  }

  public function configureCrud(Crud $crud): Crud
  {
    return $crud
      ->setEntityLabelInSingular('Header')
      ->setEntityLabelInPlural('Headers');
  }

  public function configureFields(string $pageName): iterable
  {
    $required = true;
    if ($pageName == 'edit') {
      $required = false;
    }

    return [
      TextField::new('title')
        ->setHelp('Minimum 10, maximum length is 25 characters')
        ->setFormTypeOptions([
          'constraints' => [
            new Assert\Length([
              'min' => 10,
              'max' => 30,
              'minMessage' => 'Title must be at least {{ limit }} characters long',
              'maxMessage' => 'Title cannot be longer than {{ limit }} characters',
            ]),
            new Assert\Regex([
              'pattern' => '/^[a-zA-ZÀ-ÿ0-9\s!?,.]*$/',
              'message' => 'Title name can only contain letters and underscores',
            ]),
          ]
        ]),
      TextareaField::new('content')
        ->setHelp('Minimum 10, maximum length is 70 characters')
        ->setFormTypeOptions([
          'constraints' => [
            new Assert\Length([
              'min' => 10,
              'max' => 70,
              'minMessage' => 'Content must be at least {{ limit }} characters long',
              'maxMessage' => 'Content cannot be longer than {{ limit }} characters',
            ]),
            new Assert\Regex([
              'pattern' => '/^[a-zA-ZÀ-ÿ0-9\s!?,.]*$/',
              'message' => 'Content name can only contain letters and underscores',
            ]),
          ]
        ]),
      TextField::new('buttonTitle')
        ->setHelp('Minimum 3,maximum length is 15 characters')
        ->setFormTypeOptions([
          'constraints' => [
            new Assert\Length([
              'min' => 3,
              'max' => 15,
              'minMessage' => 'Button title must be at least {{ limit }} characters long',
              'maxMessage' => 'Button title cannot be longer than {{ limit }} characters',
            ]),
            new Assert\Regex([
              'pattern' => '/^[a-zA-ZÀ-ÿ0-9\s]*$/',
              'message' => 'Button title name can only contain letters and underscores',
            ]),
          ]
        ]),
      TextField::new('buttonLink', 'URL of button')
        ->setHelp('Minimum 3,maximum length is 50 characters')
        ->setFormTypeOptions([
          'constraints' => [
            new Assert\Length([
              'min' => 3,
              'max' => 50,
              'minMessage' => 'Button title must be at least {{ limit }} characters long',
              'maxMessage' => 'Button title cannot be longer than {{ limit }} characters',
            ]),
            new Assert\Regex([
              'pattern' => '/^[a-zA-Z0-9\/]*$/',
              'message' => 'Button title name can only contain letters, numbers and slash',
            ]),
          ]
        ]),
      ImageField::new('illustration')
        ->setBasePath('/uploads/header_carousel') // the base path where files are stored
        ->setUploadDir('public/uploads/header_carousel') // the relative directory to store files in
        ->setUploadedFileNamePattern('[year]-[month]-[day]-[randomhash].[extension]') // a pattern that defines how to name the uploaded file (advanced)
        ->setHelp('Image of carousel')
        ->setRequired($required)
    ];
  }
}
