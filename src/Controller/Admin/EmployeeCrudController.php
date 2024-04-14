<?php

// src/Controller/Admin/EmployeeCrudController.php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Entity\Employee;
use App\Repository\DepartamentRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;

class EmployeeCrudController extends AbstractCrudController
{
    private $DepartamentRepository;

    public function __construct(DepartamentRepository $DepartamentRepository)
    {
        $this->DepartamentRepository = $DepartamentRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Employee::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $jobTitles = $this->DepartamentRepository->findAll();

        if (count($jobTitles) == 0) {
            $jobListEmptyAlert = $this->getJobListEmptyAlert();

            if ($jobListEmptyAlert) {
                $this->addFlash('danger', $jobListEmptyAlert);
            }
        }
        $jobChoices = [];
        foreach ($jobTitles as $jobTitle) {
            $jobChoices[$jobTitle->getId()] = $jobTitle->getName();
        }


        if ($pageName === 'edit' || $pageName === 'new') {
            if (count($jobChoices) == 0 || count($jobTitles) == 0) {
                $jobListEmptyAlert = $this->getJobListEmptyAlert();

                if ($jobListEmptyAlert) {
                    $this->addFlash('danger', $jobListEmptyAlert);
                }
            }
        }

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstName'),
            TextField::new('lastName'),
            DateField::new('joinDate'),
            TextField::new('email'),
            ChoiceField::new('position')
                ->setChoices(
                    array_flip($jobChoices)
                )
                ->setRequired(true),
        ];
    }

    private function getJobListEmptyAlert(): ?string
    {
        $jobTitles = $this->DepartamentRepository->findAll();

        if (count($jobTitles) == 0) {
            return 'The job list is empty. Please create one, before create an employee.';
        }

        return null;
    }

    public function configureActions(Actions $actions): Actions
    {
        $jobTitles = $this->DepartamentRepository->findAll();


        if (count($jobTitles) == 0) {
            return $actions
                ->remove(Crud::PAGE_INDEX, Action::NEW)
                ->remove(Crud::PAGE_INDEX, Action::EDIT);
        } else {
            return $actions
                ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                    return $action->setLabel('Add Employee');
                });
        }
    }
}
