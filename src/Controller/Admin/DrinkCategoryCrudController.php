<?php

namespace App\Controller\Admin;

use App\Entity\DrinkCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints as Assert;

class DrinkCategoryCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return DrinkCategory::class;
  }

  public function configureCrud(Crud $crud): Crud
  {
    return $crud
      ->setEntityLabelInSingular('Category of drink')
      ->setEntityLabelInPlural('Categories of drink');
  }

  public function configureFields(string $pageName): iterable
  {
    return [
      TextField::new('name')
        ->setLabel('Name of category')
        ->setHelp('Minimum 3, maximum length is 25 characters')
        ->setFormTypeOptions([
          'constraints' => [
            new Assert\Length([
              'min' => 3,
              'max' => 25,
              'minMessage' => 'Name category must be at least {{ limit }} characters long',
              'maxMessage' => 'Name category cannot be longer than {{ limit }} characters',
            ]),
            new Assert\Regex([
              'pattern' => '/^[a-zA-ZÀ-ÿ0-9\s\-_]*$/',
              'message' => 'Name category can only contain letters, numbers and underscores',
            ]),
          ]
        ]),
    ];
  }
}
