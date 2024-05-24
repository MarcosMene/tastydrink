<?php

namespace App\Controller\Admin;

use App\Entity\ReviewClient;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReviewClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ReviewClient::class;
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
            TextareaField::new('firstname'),
            AssociationField::new('user'),
            TextareaField::new('comment'),
            BooleanField::new('isApproved')->setHelp('Review client approved to appear on the homepage.'),
        ];
    }
}
