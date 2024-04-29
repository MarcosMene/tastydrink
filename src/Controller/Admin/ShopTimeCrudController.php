<?php

namespace App\Controller\Admin;

use App\Entity\ShopTime;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class ShopTimeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ShopTime::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ChoiceField::new('day')
                ->setChoices([
                    'Monday' => 'Monday',
                    'Tuesday' => 'Tuesday',
                    'Wednesday' => 'Wednesday',
                    'Thursday' => 'Thursday',
                    'Friday' => 'Friday',
                    'Saturday' => 'Saturday',
                    'Sunday' => 'Sunday',
                ]),
            TimeField::new('openTime')->setFormat('HH:mm'),
            TimeField::new('closeTime')->setFormat('HH:mm'),
        ];
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Bar Time', 'fas fa-clock', ShopTime::class);
    }
}