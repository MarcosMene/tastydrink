<?php

namespace App\Controller\Admin;

use App\Entity\ReviewClient;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;

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
            ->setEntityLabelInPlural('Reviews Clients')
            ->setDefaultSort(['id' => 'DESC'])
            // the max number of entities to display per page
            ->setPaginatorPageSize(5);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn(6),
            AssociationField::new('user'),
            TextField::new('firstname')
                ->setLabel('First name'),
            ChoiceField::new('rate', 'Note')
                ->setChoices([
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ])->renderExpanded(),
            BooleanField::new('isApproved')->setHelp('Review client approved to appear on the homepage.'),
            TextareaField::new('comment'),
        ];
    }

    //to hide create button order on dashboard and hide edit and delete button on user
    public function configureActions(Actions $actions): Actions
    {

        //variable to create button show detail order
        $show = Action::new('Show')->linkToCrudAction('show');

        return $actions
            //remove button new from dashboard
            ->add(Crud::PAGE_INDEX, $show)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE);
    }

    //function to show details of order on easyadmin
    //adminurlgenerator to generate the state value on the url
    public function show(AdminContext $context, AdminUrlGenerator $adminUrlGenerator, Request $request)
    {
        $reviewClient = $context->getEntity()->getInstance();

        //recover URL of action 'SHOW'
        $url = $adminUrlGenerator->setController(self::class)->setAction('show')->setEntityId($reviewClient->getId())->generateUrl();

        return $this->render('admin/productReviewClient.html.twig', [
            'reviewClient' => $reviewClient,
            'current_url' => $url
        ]);
    }
}
