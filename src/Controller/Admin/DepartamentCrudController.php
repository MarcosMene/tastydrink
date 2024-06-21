<?php

namespace App\Controller\Admin;

use App\Entity\Departament;
use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Validator\Constraints as Assert;

class DepartamentCrudController extends AbstractCrudController
{
  private $employeeRepository;

  public function __construct(EmployeeRepository $employeeRepository)
  {
    $this->employeeRepository = $employeeRepository;
  }

  public static function getEntityFqcn(): string
  {
    return Departament::class;
  }

  public function configureCrud(Crud $crud): Crud
  {
    return $crud
      ->setEntityLabelInSingular('Department')
      ->setEntityLabelInPlural('Departments');
  }

  public function configureFields(string $pageName): iterable
  {
    return [
      TextField::new('name')
        ->setLabel('Name of department')
        ->setHelp('Minimum 3, maximum length is 15 characters')
        ->setFormTypeOptions([
          'constraints' => [
            new Assert\Length([
              'min' => 3,
              'max' => 15,
              'minMessage' => 'Name department must be at least {{ limit }} characters long',
              'maxMessage' => 'Name department cannot be longer than {{ limit }} characters',
            ]),
            new Assert\Regex([
              'pattern' => '/^[a-zA-ZÀ-ÿ\s\-_]*$/',
              'message' => 'Name department can only contain letters and underscores',
            ]),
          ]
        ]),
    ];
  }

  /**
   * @ORM\PreRemove
   */
  public function onDepartmentRemove(Departament $jobTitle)
  {
    $employees = $this->employeeRepository->getRepository(Employee::class)->findBy(['position' => $jobTitle->getName()]);

    foreach ($employees as $employee) {
      $employee->setPosition('no job');
    }
    $this->employeeRepository->flush();
  }
}
