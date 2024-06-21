<?php

namespace App\Controller\Admin;

use App\Entity\ShopTime;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class ShopTimeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ShopTime::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Shop time')
            ->setEntityLabelInPlural('Shop times');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('day')
                ->setChoices([
                    'Monday' => 'Monday',
                    'Tuesday' => 'Tuesday',
                    'Wednesday' => 'Wednesday',
                    'Thursday' => 'Thursday',
                    'Friday' => 'Friday',
                    'Saturday' => 'Saturday',
                    'Sunday' => 'Sunday',
                ])
                ->setFormTypeOption('placeholder', 'Choose a day')
                ->setRequired(true),
            TimeField::new('openTime')
                ->setFormat('HH:mm')
                ->setRequired(true),
            TimeField::new('closeTime')->setFormat('HH:mm'),
        ];
    }
}
