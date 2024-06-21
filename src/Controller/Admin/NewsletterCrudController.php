<?php

namespace App\Controller\Admin;

use App\Entity\Newsletter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints as Assert;

class NewsletterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Newsletter::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Newsletter')
            ->setEntityLabelInPlural('Newsletters');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email')
                ->setLabel('Email')
                ->setFormTypeOptions([
                    'constraints' => [
                        new Assert\Length([
                            'min' => 10,
                            'max' => 50,
                            'minMessage' => 'Email must be at least {{ limit }} characters long',
                            'maxMessage' => 'Email cannot be longer than {{ limit }} characters',
                        ]),
                        new Assert\Email([
                            'message' => 'Invalid email address',
                        ]),
                    ]
                ]),
        ];
    }

    //to hide create button order on dashboard and hide edit and delete button on user
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            //remove new button from dashboard
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT);
    }
}
