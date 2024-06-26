<?php

namespace App\Controller\Admin;

use App\Entity\Drink;
use App\Repository\DrinkCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints as Assert;

class DrinkCrudController extends AbstractCrudController
{

  private $drinkCategoryRepository;

  public function __construct(DrinkCategoryRepository $drinkCategoryRepository)
  {
    $this->drinkCategoryRepository = $drinkCategoryRepository;
  }

  public static function getEntityFqcn(): string
  {
    return Drink::class;
  }

  public function configureCrud(Crud $crud): Crud
  {
    return $crud
      ->setEntityLabelInSingular('Menu Drink')
      ->setEntityLabelInPlural('Menu Drinks')
      ->setDefaultSort(['id' => 'DESC'])
      // the max number of entities to display per page
      ->setPaginatorPageSize(5);
  }

  public function configureFields(string $pageName): iterable
  {
    //if mode edit, image is not required, but if new product, image is required
    $required = true;
    if ($pageName == 'edit') {
      $required = false;
    }

    //find all drink categories
    $drinkCategs = $this->drinkCategoryRepository->findAll();

    if (count($drinkCategs) == 0) {
      $categoryEmptyAlert = $this->getCategoryEmptyAlert();

      if ($categoryEmptyAlert) {
        $this->addFlash('danger', $categoryEmptyAlert);
      }
    }

    //array to save all categories
    $drinkChoices = [];
    foreach ($drinkCategs as $DrinkCateg) {
      $drinkChoices[$DrinkCateg->getId()] = $DrinkCateg->getName();
    }

    if ($pageName === 'edit' || $pageName === 'new') {
      if (count($drinkChoices) == 0 || count($drinkChoices) == 0) {
        $categoryEmptyAlert = $this->getCategoryEmptyAlert();

        if ($categoryEmptyAlert) {
          $this->addFlash('danger', $categoryEmptyAlert);
        }
      }
    }

    return [
      FormField::addColumn(6),
      IdField::new('id')->hideOnForm(),
      TextField::new('name')
        ->setHelp('Minimum length is 10, maximum 25 characters')
        ->setFormTypeOptions([
          'constraints' => [
            new Assert\Length([
              'min' => 10,
              'max' => 25,
              'minMessage' => 'Drink name must be at least {{ limit }} characters long',
              'maxMessage' => 'Drink name cannot be longer than {{ limit }} characters',
            ]),
            new Assert\Regex([
              'pattern' => '/^[a-zA-ZÀ-ÿ0-9\s\-_]*$/',
              'message' => 'Drink name can only contain letters, numbers, and underscores',
            ]),
          ]
        ]),
      TextareaField::new('description')
        ->setHelp('Minimum length is 50, maximum 150 characters')
        ->setFormTypeOptions([
          'constraints' => [
            new Assert\Length([
              'min' => 50,
              'max' => 150,
              'minMessage' => 'Description must be at least {{ limit }} characters long',
              'maxMessage' => 'Description cannot be longer than {{ limit }} characters',
            ]),
            new Assert\Regex([
              'pattern' => '/^[a-zA-ZÀ-ÿ0-9.,\s\-_]*$/',
              'message' => 'Description can only contain letters, numbers, and underscores',
            ]),
          ]
        ]),
      FormField::addColumn(6),
      AssociationField::new('drinkcategory', 'category of drinks')
        ->setFormTypeOption('placeholder', 'Choose a Category')
        ->setRequired(true),
      ImageField::new('illustration')
        ->setBasePath('/uploads/menu') // the base path where files are stored
        ->setUploadDir('public/uploads/menu') // the relative directory to store files in
        ->setUploadedFileNamePattern('[year]-[month]-[day]-[randomhash].[extension]') // a pattern that defines how to name the uploaded file (advanced)
        ->setRequired($required)
        ->setHelp('Image of your product, max 500x500px'),
      NumberField::new('price')
        ->setHelp('Minimum 5, maximum 50 dolars')
        ->setFormTypeOptions([
          'constraints' => [
            new Assert\Positive(),
            new Assert\Range([
              'min' => 5,
              'max' => 50,
              'notInRangeMessage' => 'The price must be from {{ min }} to {{ max }}.',
            ])
          ]
        ])
        ->setRequired(true),



    ];
  }

  private function getCategoryEmptyAlert(): ?string
  {
    //find all drink categories
    $drinkCategs = $this->drinkCategoryRepository->findAll();

    if (count($drinkCategs) == 0) {
      return 'The list of category drinks is empty. Please create one, before create an drink.';
    }
    return null;
  }

  public function configureActions(Actions $actions): Actions
  {
    //find all drink categories
    $drinkCategs = $this->drinkCategoryRepository->findAll();

    if (count($drinkCategs) == 0) {
      return $actions
        ->remove(Crud::PAGE_INDEX, Action::NEW)
        ->remove(Crud::PAGE_INDEX, Action::EDIT);
    } else {
      return $actions
        ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
          return $action->setLabel('Add Drink');
        });
    }
  }
}
