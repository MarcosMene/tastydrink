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
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints as Assert;

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
      ->setEntityLabelInPlural('Employees')
      ->setDefaultSort(['joinDate' => 'DESC'])
      ->setPaginatorPageSize(5);
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
      FormField::addColumn(6),
      IdField::new('id')->hideOnForm(),
      TextField::new('firstName')
        ->setFormTypeOptions([
          'constraints' => [
            new Assert\Length([
              'min' => 3,
              'max' => 25,
              'minMessage' => 'First name must be at least {{ limit }} characters long',
              'maxMessage' => 'First name cannot be longer than {{ limit }} characters',
            ]),
            new Assert\Regex([
              'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]/',
              'message' => 'First name can only contain letters, numbers, and -',
            ]),
          ]
        ])
        ->setRequired(true),
      TextField::new('lastName')
        ->setFormTypeOptions([
          'constraints' => [
            new Assert\Length([
              'min' => 3,
              'max' => 25,
              'minMessage' => 'Last name must be at least {{ limit }} characters long',
              'maxMessage' => 'Last name cannot be longer than {{ limit }} characters',
            ]),
            new Assert\Regex([
              'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]/',
              'message' => 'Last name can only contain letters, numbers, and -',
            ]),
          ]
        ])
        ->setRequired(true),
      ImageField::new('illustration')
        ->setBasePath('/uploads/team') // the base path where files are stored
        ->setUploadDir('public/uploads/team') // the relative directory to store files in
        ->setUploadedFileNamePattern('[year]-[month]-[day]-[randomhash].[extension]') // a pattern that defines how to name the uploaded file (advanced)
        ->setRequired($required)
        ->setHelp('Image of your product, max 500x500px'),
      DateField::new('joinDate')
        ->setFormTypeOptions([
          'constraints' => [
            new Assert\Type("\DateTimeInterface"),
            new Assert\GreaterThanOrEqual('2020-01-01'),
            new Assert\LessThanOrEqual(new \DateTime('+10 days'))
          ]
        ])
        ->setRequired(true),
      FormField::addColumn(6),
      TextField::new('email')
        ->setFormTypeOptions([
          'constraints' => [
            new Assert\NotBlank(['message' => 'Email cannot be blank.']),
            new Assert\Length([
              'min' => 10,
              'max' => 50,
              'minMessage' => 'Email must be at least {{ limit }} characters long',
              'maxMessage' => 'Email cannot be longer than {{ limit }} characters',
            ]),
            new Assert\Email([
              'message' => 'Invalid email address',
            ]),
          ]
        ])
        ->setRequired(true),
      AssociationField::new('team', 'Team')
        ->setHelp('Which team to work')
        ->setFormTypeOption('placeholder', 'Choose a team')
        ->setRequired(true),
      ChoiceField::new('position')
        ->setHelp('Which positon on the team')
        ->setChoices(
          array_flip($jobChoices)
        )
        ->setFormTypeOption('placeholder', 'Choose a position')
        ->setRequired(true),
      ChoiceField::new('orderAppear')
        ->setChoices([
          '1' => '1',
          '2' => '2',
        ])
        ->setFormTypeOption('placeholder', 'Choose a order')
        ->setRequired(true)
        ->setHelp('Choose order employee appears on the page'),
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
