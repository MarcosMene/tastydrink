<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class OrderCrudController extends AbstractCrudController
{

    private $entityManager;
    private $crudUrlGenerator;

    public function __construct(EntityManagerInterface $entityManager, AdminUrlGenerator $crudUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->crudUrlGenerator = $crudUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Order')
            ->setEntityLabelInPlural('Orders');
    }

    //to hide create button order on dashboard and hide edit and delete button on order
    public function configureActions(Actions $actions): Actions
    {
        //variable to create button show detail order
        $show = Action::new('Show')->linkToCrudAction('show');

        //variable to create button change state to in preparation
        $updatePreparation = Action::new('updatePreparation', 'Preparation in Progress', 'fas fa-box-open')->linkToCrudAction('updatePreparation');

        //variable to create button change state to delivery
        $updateDelivery = Action::new('updateDelivery', 'Delivery in progress', 'fas fa-truck')->linkToCrudAction('updateDelivery');


        return $actions
            //add personal action to show detail order
            ->add(Crud::PAGE_INDEX, $updateDelivery)
            ->add(Crud::PAGE_INDEX, $updatePreparation)
            ->add(Crud::PAGE_INDEX, $show)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE);
    }

    //function to show details of order on easyadmin
    public function show(AdminContext $context)
    {
        $order = $context->getEntity()->getInstance();

        return $this->render('admin/order.html.twig', [
            'order' => $order
        ]);
    }


    //function to update preparation of order on easyadmin
    public function updatePreparation(AdminContext $context)
    {
        $order = $context->getEntity()->getInstance();

        //change state of order
        $order->setState(3);
        $this->entityManager->flush();

        //message
        $this->addFlash('notice', "<span style='color:blue;'> <strong>Your order " . $order->getId() . " is in preparation.</strong> </span>");

        $url = $this->crudUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

        //here is the code to send email to the user **********


        return $this->redirect($url);
    }


    //function to send order to user address
    public function updateDelivery(AdminContext $context)
    {
        $order = $context->getEntity()->getInstance();

        //change state of order
        $order->setState(4);
        $this->entityManager->flush();

        //message
        $this->addFlash('notice', "<span style='color:orange;'> <strong>Your order " . $order->getId() . " is being shipped.</strong> </span>");

        $url = $this->crudUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

        //here is the code to send email to the user **********

        return $this->redirect($url);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateField::new('createdAt')->setLabel('Date'),
            NumberField::new('state')->setTemplatePath('admin/state.html.twig'),
            AssociationField::new('user')->setLabel('Client'),
            TextField::new('carrierName')->setLabel('Carrier'),
            NumberField::new('totalTva')->setLabel('Total VAT'),
            NumberField::new('totalWt')->setLabel('Total Order'),
        ];
    }
}
