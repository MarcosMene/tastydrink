<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Reservation')
            ->setEntityLabelInPlural('Reservations')
            ->setDefaultSort(['reservationDate' => 'DESC'])
            ->setPaginatorPageSize(5);
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

    //to hide create button order on dashboard and hide edit and delete button on reservation
    public function configureActions(Actions $actions): Actions
    {
        //variable to create button show detail order
        $show = Action::new('Show')->linkToCrudAction('show');

        return $actions
            //add personal action to show detail order
            ->add(Crud::PAGE_INDEX, $show)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE);
    }

    //function to show details of order on easyadmin
    //adminurlgenerator to generate the state value on the url
    public function show(AdminContext $context, AdminUrlGenerator $adminUrlGenerator, Request $request)
    {
        $reservation = $context->getEntity()->getInstance();

        //recover URL of action 'SHOW'
        $url = $adminUrlGenerator->setController(self::class)->setAction('show')->setEntityId($reservation->getId())->generateUrl();

        return $this->render('admin/reservation.html.twig', [
            'reservation' => $reservation,
            'current_url' => $url
        ]);
    }
}
