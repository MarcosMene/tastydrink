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
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
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

  public function configureCrud(Crud $crud): Crud
  {
    return $crud
      ->setEntityLabelInSingular('Employee')
      ->setEntityLabelInPlural('Employees');
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

    //if mode edit, image is not required, but if new product, image is required
    $required = true;
    if ($pageName == 'edit') {
      $required = false;
    }

    return [
      IdField::new('id')->hideOnForm(),
      TextField::new('firstName'),
      TextField::new('lastName'),
      ImageField::new('illustration')
        ->setBasePath('/uploads/team') // the base path where files are stored
        ->setUploadDir('public/uploads/team') // the relative directory to store files in
        ->setUploadedFileNamePattern('[year]-[month]-[day]-[randomhash].[extension]') // a pattern that defines how to name the uploaded file (advanced)
        ->setRequired($required)
        ->setHelp('Image of your product, max 500x500px'),
      DateField::new('joinDate')
        ->setRequired(true),
      TextField::new('email'),
      AssociationField::new('team', 'Team')->setHelp('Which team to work')
        ->setRequired(true),
      ChoiceField::new('position')
        ->setHelp('Which positon on the team')
        ->setChoices(
          array_flip($jobChoices)
        )
        ->setRequired(true),
      NumberField::new('orderAppear')->setHelp('Order appear on the team page. From 1 to 5')
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
