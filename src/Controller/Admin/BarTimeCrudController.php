<?php

namespace App\Controller\Admin;

use App\Entity\BarTime;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class BarTimeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BarTime::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Bar Time')
            ->setEntityLabelInPlural('Bar Times');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn(3),
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
            TimeField::new('closeTime')
                ->setFormat('HH:mm')
                ->setRequired(true),
        ];
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Bar Time', 'fas fa-clock', BarTime::class);
    }
}
