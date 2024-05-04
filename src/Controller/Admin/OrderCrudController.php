<?php

namespace App\Controller\Admin;

use App\Classe\Mail;
use App\Classe\State;
use App\Entity\Order;
use Doctrine\ORM\EntityManager;
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
use Symfony\Component\HttpFoundation\Request;

class OrderCrudController extends AbstractCrudController
{

    private $em;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->em = $entityManagerInterface;
    }




    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Order')
            ->setEntityLabelInPlural('Orders')

            // the max number of entities to display per page
            ->setPaginatorPageSize(10);
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

    /**
     * function for changing order status
     */
    public function changeState($order, $state)
    {

        //change state of order status
        $order->setState($state);
        $this->em->flush();

        $this->addFlash('success', 'Updated order status');




        //send email to client to inform the situation of his/her order
        $mail = new Mail();
        $vars = [
            "firstname" => $order->getUser()->getFirstname(),
            'lastname' => $order->getUser()->getLastname(),
            'id_order' => $order->getId()
        ];
        $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstName() . ' ' . $order->getUser()->getLastName(), State::STATE[$state]['email_subject'], State::STATE[$state]['email_template'], $vars);
    }
    //function to show details of order on easyadmin
    //adminurlgenerator to generate the state value on the url
    public function show(AdminContext $context, AdminUrlGenerator $adminUrlGenerator, Request $request)
    {
        $order = $context->getEntity()->getInstance();

        //recover URL of action 'SHOW'
        $url = $adminUrlGenerator->setController(self::class)->setAction('show')->setEntityId($order->getId())->generateUrl();


        //verify if state parameter is present on the url
        if ($request->get('state')) {
            $this->changeState($order, $request->get('state'));
        }

        return $this->render('admin/order.html.twig', [
            'order' => $order,
            'current_url' => $url
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
