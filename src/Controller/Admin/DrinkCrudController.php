<?php

namespace App\Controller\Admin;

use App\Entity\Drink;
use App\Entity\DrinkCategory;
use App\Repository\DrinkCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
            ->setEntityLabelInSingular('Menu drink')
            ->setEntityLabelInPlural('Menu drinks');
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
            AssociationField::new('drinkcategory', 'category of drinks')
                ->setRequired(true)
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
