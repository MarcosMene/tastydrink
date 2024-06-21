<?php

namespace App\Controller\Admin;

use App\Entity\ReviewClient;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReviewClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ReviewClient::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Review Client')
            ->setEntityLabelInPlural('Reviews Clients');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('rate', 'Note')
                ->setChoices([
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ])->renderExpanded(),
            TextField::new('firstname'),
            BooleanField::new('isApproved')->setHelp('Review client approved to appear on the homepage.'),
            AssociationField::new('user'),
            TextareaField::new('comment'),
        ];
    }

    //to hide create button from dashboard
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            //remove button new from dashboard
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }
}
