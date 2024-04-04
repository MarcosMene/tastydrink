<?php

namespace App\Controller\Admin;

use App\Entity\Order;
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

class OrderCrudController extends AbstractCrudController
{
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
        //variable to create buton show detail order
        $show = Action::new('Show')->linkToCrudAction('show');


        return $actions
            //add personal action to show detail order
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
