<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('user')->onlyOnIndex()
                ->setLabel('User name'),
            TextField::new('user.email')->onlyOnIndex()
                ->setLabel('User email'),
            TextField::new('firstname')
                ->setLabel('Name'),
            TextField::new('lastname')
                ->setLabel('Lastname'),
            TextField::new('telephone'),
            IntegerField::new('numberOfPeople'),
            BooleanField::new('cancelReservation')->setHelp('Reservation cancel'),
            DateField::new('reservationDate')
                ->setLabel('Date'),
            TimeField::new('reservationTime')
                ->setLabel('Hour'),
        ];
    }
}
