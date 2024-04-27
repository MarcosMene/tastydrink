<?php

namespace App\Controller\Admin;

use App\Entity\Food;
use App\Repository\FoodCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FoodCrudController extends AbstractCrudController
{

  private $foodCategoryRepository;

  public function __construct(FoodCategoryRepository $foodCategoryRepository)
  {
    $this->foodCategoryRepository = $foodCategoryRepository;
  }



  public static function getEntityFqcn(): string
  {
    return Food::class;
  }

  public function configureCrud(Crud $crud): Crud
  {
    return $crud
      ->setEntityLabelInSingular('Menu food')
      ->setEntityLabelInPlural('Menu foods');
  }

  public function configureFields(string $pageName): iterable
  {
    //if mode edit, image is not required, but if new product, image is required
    $required = true;
    if ($pageName == 'edit') {
      $required = false;
    }


    //find all food categories
    $foodCategs = $this->foodCategoryRepository->findAll();

    if (count($foodCategs) == 0) {
      $categoryEmptyAlert = $this->getCategoryEmptyAlert();

      if ($categoryEmptyAlert) {
        $this->addFlash('danger', $categoryEmptyAlert);
      }
    }

    //array to save all categories
    $foodChoices = [];
    foreach ($foodCategs as $foodCateg) {
      $foodChoices[$foodCateg->getId()] = $foodCateg->getName();
    }

    if ($pageName === 'edit' || $pageName === 'new') {
      if (count($foodChoices) == 0 || count($foodChoices) == 0) {
        $categoryEmptyAlert = $this->getCategoryEmptyAlert();

        if ($categoryEmptyAlert) {
          $this->addFlash('danger', $categoryEmptyAlert);
        }
      }
    }

    return [
      IdField::new('id')->hideOnForm(),
      TextField::new('name'),
      TextEditorField::new('description'),
      NumberField::new('price'),
      ImageField::new('illustration')
        ->setBasePath('/uploads/menu') // the base path where files are stored
        ->setUploadDir('public/uploads/menu') // the relative directory to store files in
        ->setUploadedFileNamePattern('[year]-[month]-[day]-[randomhash].[extension]') // a pattern that defines how to name the uploaded file (advanced)
        ->setRequired($required)
        ->setHelp('Image of your product, 600x600px'),
      AssociationField::new('foodcategory', 'category of foods')
        ->setRequired(true)
    ];
  }


  private function getCategoryEmptyAlert(): ?string
  {
    //find all drink categories
    $foodCategs = $this->foodCategoryRepository->findAll();

    if (count($foodCategs) == 0) {
      return 'The list of category drinks is empty. Please create one, before create an drink.';
    }

    return null;
  }

  public function configureActions(Actions $actions): Actions
  {
    //find all food categories
    $foodCategs = $this->foodCategoryRepository->findAll();


    if (count($foodCategs) == 0) {
      return $actions
        ->remove(Crud::PAGE_INDEX, Action::NEW)
        ->remove(Crud::PAGE_INDEX, Action::EDIT);
    } else {
      return $actions
        ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
          return $action->setLabel('Add Food');
        });
    }
  }
}
