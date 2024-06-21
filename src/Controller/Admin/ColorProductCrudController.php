<?php

namespace App\Controller\Admin;

use App\Entity\ColorProduct;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints as Assert;

class ColorProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ColorProduct::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Color')
            ->setEntityLabelInPlural('Colors');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('color')
                ->setLabel('Color')
                ->setHelp('Minimum 3, maximum length is 25 characters')
                ->setFormTypeOptions([
                    'constraints' => [
                        new Assert\Length([
                            'min' => 3,
                            'max' => 25,
                            'minMessage' => 'Color must be at least {{ limit }} characters long',
                            'maxMessage' => 'Color cannot be longer than {{ limit }} characters',
                        ]),
                        new Assert\Regex([
                            'pattern' => '/^[a-zA-ZÀ-ÿ\s\-_]*$/',
                            'message' => 'Color name can only contain letters and underscores',
                        ]),
                    ]
                ]),
        ];
    }
}
