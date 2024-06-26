<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints as Assert;

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
            ->setEntityLabelInPlural('Products')
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

        return [
            FormField::addColumn(6),
            TextField::new('name')
                ->setLabel('Name')
                ->setFormTypeOptions([
                    'constraints' => [
                        new Assert\Length([
                            'min' => 3,
                            'max' => 40,
                            'minMessage' => 'Product name must be at least {{ limit }} characters long',
                            'maxMessage' => 'Product name cannot be longer than {{ limit }} characters',
                        ]),
                        new Assert\Regex([
                            'pattern' => '/^[a-zA-ZÀ-ÿ0-9\s\-_]*$/',
                            'message' => 'Product name can only contain letters, numbers, and underscores',
                        ]),
                    ]
                ]),
            SlugField::new('slug')->setTargetFieldName('name')->setHelp('URL of the category based on the title'),
            BooleanField::new('isSuggestion')->setHelp('Product suggestion on home page.'),
            ImageField::new('illustration')
                ->setHelp('Image of the product')
                ->setBasePath('/uploads/products') // the base path where files are stored
                ->setUploadDir('public/uploads/products') // the relative directory to store files in
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[randomhash].[extension]') // a pattern that defines how to name the uploaded file (advanced)
                ->setRequired($required),
            TextareaField::new('description')
                ->setHelp('Minimum length is 20, maximum 200 characters')
                ->setFormTypeOptions([
                    'constraints' => [
                        new Assert\Length([
                            'min' => 20,
                            'max' => 200,
                            'minMessage' => 'Description must be at least {{ limit }} characters long',
                            'maxMessage' => 'Description cannot be longer than {{ limit }} characters',
                        ]),
                        new Assert\Regex([
                            'pattern' => '/^[a-zA-ZÀ-ÿ0-9\s!?,.]*$/',
                            'message' => 'Description can only contain letters, numbers, and underscores',
                        ]),
                    ]
                ]),
            FormField::addColumn(6),
            AssociationField::new('colorProduct')
                ->setLabel('Color of product')
                ->setFormTypeOption('placeholder', 'Choose a color')
                ->setRequired(true),
            NumberField::new('price')->setHelp('Price of the product without tax. From 10 to 100')
                ->setFormTypeOptions([
                    'constraints' => [
                        new Assert\Positive(),
                        new Assert\Range([
                            'min' => 10,
                            'max' => 100,
                            'notInRangeMessage' => 'The price must be from {{ min }} to {{ max }}.',
                        ])
                    ]
                ])
                ->setRequired(true),
            ChoiceField::new('tva')
                ->setHelp('Tax of the product')
                ->setChoices([
                    '5.5%' => '5.5',
                    '10%' => '10',
                    '20%' => '20',
                ])
                ->setLabel('VAT')
                ->formatValue(function ($value) {
                    return number_format($value, 2);
                }),
            AssociationField::new('category')->setHelp('Category of the product')
                ->setFormTypeOption('placeholder', 'Choose a Category')
                ->setRequired(true),
            AssociationField::new('countryProduct')->setHelp('Country of the product')
                ->setLabel('Country')
                ->setFormTypeOption('placeholder', 'Choose a country')
                ->setRequired(true),
        ];
    }
}
