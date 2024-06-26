<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;

class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Product Review')
            ->setEntityLabelInPlural('Product Reviews')
            ->setDefaultSort(['id' => 'DESC'])
            // the max number of entities to display per page
            ->setPaginatorPageSize(5);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user'),
            AssociationField::new('product'),
            ChoiceField::new('rate', 'Note')
                ->setChoices([
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ])->renderExpanded(),
            BooleanField::new('is_approved'),
            TextareaField::new('review'),
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
        $review = $context->getEntity()->getInstance();

        //recover URL of action 'SHOW'
        $url = $adminUrlGenerator->setController(self::class)->setAction('show')->setEntityId($review->getId())->generateUrl();

        return $this->render('admin/productReview.html.twig', [
            'review' => $review,
            'current_url' => $url
        ]);
    }
}
