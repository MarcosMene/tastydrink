<?php

namespace App\Controller\Admin;

use App\Entity\FoodCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints as Assert;

class FoodCategoryCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return FoodCategory::class;
  }

  public function configureCrud(Crud $crud): Crud
  {
    return $crud
      ->setEntityLabelInSingular('Category of food')
      ->setEntityLabelInPlural('Category of foods')
      ->setDefaultSort(['id' => 'DESC'])
      // the max number of entities to display per page
      ->setPaginatorPageSize(5);
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
      NumberField::new('orderAppear')
        ->setHelp('Order appear on the team page. From 1 to 5')
        ->setFormTypeOptions([
          'constraints' => [
            new Assert\Positive(),
            new Assert\Range([
              'min' => 1,
              'max' => 5,
              'notInRangeMessage' => 'Order appear must be from {{ min }} to {{ max }}.',
            ])
          ]
        ])
        ->setRequired(true),
    ];
  }
}
