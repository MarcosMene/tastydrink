<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints as Assert;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('Users')
            ->setDefaultSort(['email' => 'DESC'])
            ->setPaginatorPageSize(5);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn(6),
            TextField::new('firstname')
                ->setLabel('First name')
                ->setHelp('Maximum length is 25 characters')
                ->setFormTypeOptions([
                    'constraints' => [
                        new Assert\Length([
                            'min' => 3,
                            'max' => 25,
                            'minMessage' => 'First name must be at least {{ limit }} characters long',
                            'maxMessage' => 'First name cannot be longer than {{ limit }} characters',
                        ]),
                        new Assert\Regex([
                            'pattern' => '/^[a-zA-ZÀ-ÿ\s\-_]*$/',
                            'message' => 'First name can only contain letters and underscores',
                        ]),
                    ]
                ]),
            TextField::new('email')
                ->setLabel('Email')
                ->setHelp('Minimum 10, maximum length is 50 characters')
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
            FormField::addColumn(6),
            TextField::new('lastname')
                ->setLabel('Last name')
                ->setHelp('Minimum 3, maximum length is 25 characters')
                ->setFormTypeOptions([
                    'constraints' => [
                        new Assert\Length([
                            'min' => 3,
                            'max' => 25,
                            'minMessage' => 'First name must be at least {{ limit }} characters long',
                            'maxMessage' => 'First name cannot be longer than {{ limit }} characters',
                        ]),
                        new Assert\Regex([
                            'pattern' => '/^[a-zA-ZÀ-ÿ\s\-_]*$/',
                            'message' => 'First name can only contain letters and underscores',
                        ]),
                    ]
                ]),

            DateField::new('lastLoginAt')->setLabel('Last connection time')->onlyOnIndex(),
            FormField::addColumn(6),
            ChoiceField::new('roles')->setLabel('Role permission')->setHelp('Choose the role of this user')->setChoices([
                'ROLE_USER' => 'ROLE_USER',
                'ROLE_ADMIN' => 'ROLE_ADMIN',
            ])->allowMultipleChoices(),
            BooleanField::new('isConfirmed')->setHelp('User confirmed his email.'),
        ];
    }

    //to hide create button order on dashboard and hide edit and delete button on user
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            //remove new button from dashboard
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }
}
