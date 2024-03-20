<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Product')
            ->setEntityLabelInPlural('Products');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')->setHelp('Name of your product'),
            SlugField::new('slug')->setTargetFieldName('name')->setHelp('URL of the category based on the title'),
            ImageField::new('illustration')
                ->setBasePath('/uploads/products') // the base path where files are stored
                ->setUploadDir('public/uploads/products') // the relative directory to store files in
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[randomhash].[extension]') // a pattern that defines how to name the uploaded file (advanced)
                ->setRequired(false)
                ->setHelp('Image of your product, 600x600px'),
            TextField::new('subtitle')->setHelp('Subtitle of your product'),
            TextEditorField::new('description')->setHelp('Description of your product'),
            MoneyField::new('price')->setCurrency('USD')->setHelp('Price of your product without tax'),
            ChoiceField::new('tva')
                ->setHelp('Tax of your product')
                ->setChoices([
                    '5,5%' => '5.5',
                    '10%' => '10',
                    '20%' => '20',
                ]),
            AssociationField::new('category')->setHelp('Category of your product')

        ];
    }
}
