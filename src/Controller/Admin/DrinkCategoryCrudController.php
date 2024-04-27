<?php

namespace App\Controller\Admin;

use App\Entity\DrinkCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
      ->setEntityLabelInPlural('Category of drinks');
  }



  /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
