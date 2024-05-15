<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
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
        //if mode edit, image is not required, but if new product, image is required
        $required = true;
        if ($pageName == 'edit') {
            $required = false;
        }


        return [
            TextField::new('name')->setLabel('Name'),
            BooleanField::new('isSuggestion')->setHelp('Product suggestion on home page.'),
            SlugField::new('slug')->setTargetFieldName('name')->setHelp('URL of the category based on the title'),
            ImageField::new('illustration')
                ->setHelp('Image of the product')
                ->setBasePath('/uploads/products') // the base path where files are stored
                ->setUploadDir('public/uploads/products') // the relative directory to store files in
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[randomhash].[extension]') // a pattern that defines how to name the uploaded file (advanced)
                ->setRequired($required),
            TextField::new('subtitle')->setHelp('Subtitle of your product'),
            TextEditorField::new('description'),
            NumberField::new('price')->setHelp('Price of the product without tax'),
            ChoiceField::new('tva')
                ->setHelp('Tax of the product')
                ->setChoices([
                    '5,5%' => '5.5',
                    '10%' => '10',
                    '20%' => '20',
                ])
                ->setLabel('VAT'),
            AssociationField::new('category')->setHelp('Category of the product'),
            // AssociationField::new('colorProduct')->setHelp('Color of the product'),
            AssociationField::new('countryProduct')->setHelp('Country of the product')

        ];
    }
}
