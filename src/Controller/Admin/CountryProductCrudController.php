<?php

namespace App\Controller\Admin;

use App\Entity\CountryProduct;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints as Assert;

class CountryProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CountryProduct::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Country of product')
            ->setEntityLabelInPlural('Countries of product');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('country')
                ->setLabel('Country')
                ->setHelp('Minimum 3, maximum length is 25 characters')
                ->setFormTypeOptions([
                    'constraints' => [
                        new Assert\Length([
                            'min' => 3,
                            'max' => 25,
                            'minMessage' => 'Country must be at least {{ limit }} characters long',
                            'maxMessage' => 'Country cannot be longer than {{ limit }} characters',
                        ]),
                        new Assert\Regex([
                            'pattern' => '/^[a-zA-ZÀ-ÿ\s\-_]*$/',
                            'message' => 'Country name can only contain letters and underscores',
                        ]),
                    ]
                ]),
        ];
    }
}
