<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints as Assert;

class CarrierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Carrier::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Carrier')
            ->setEntityLabelInPlural('Carriers')
            // the max number of entities to display per page
            ->setPaginatorPageSize(5);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn(6),
            TextField::new('name')
                ->setLabel('Carriers name')
                ->setHelp('Minimum 3, maximum length is 15 characters')
                ->setFormTypeOptions([
                    'constraints' => [
                        new Assert\Length([
                            'min' => 3,
                            'max' => 50,
                            'minMessage' => 'Carriers name must be at least {{ limit }} characters long',
                            'maxMessage' => 'Carriers name cannot be longer than {{ limit }} characters',
                        ]),
                        new Assert\Regex([
                            'pattern' => '/^[a-zA-ZÀ-ÿ0-9\s]*$/',
                            'message' => 'Carriers name can only contain letters, numbers, and underscores',
                        ]),
                    ]
                ]),
            TextareaField::new('description')
                ->setHelp('Minimum 10, maximum length is 30 characters')
                ->setFormTypeOptions([
                    'constraints' => [
                        new Assert\Length([
                            'min' => 10,
                            'max' => 30,
                            'minMessage' => 'Description must be at least {{ limit }} characters long',
                            'maxMessage' => 'Description cannot be longer than {{ limit }} characters',
                        ]),
                        new Assert\Regex([
                            'pattern' => '/^[a-zA-ZÀ-ÿ0-9\s!?,.]*$/',
                            'message' => 'Carriers name can only contain letters, numbers, and underscores',
                        ]),
                    ]
                ]),
            NumberField::new('price')
                ->setLabel('Price with VAT')
                ->setHelp('Price of your carrier with tax')
                ->setFormTypeOptions([
                    'constraints' => [
                        new Assert\Positive(),
                        new Assert\Range(
                            min: 1,
                            max: 30,
                            notInRangeMessage: 'The price must be between ${{ min }} and ${{ max }}',
                        )
                    ]
                ])
        ];
    }
}
