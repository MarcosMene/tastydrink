<?php

// namespace App\Controller\Admin;

// use App\Entity\Departament;
// use App\Repository\EmployeeRepository;
// use Doctrine\ORM\EntityManagerInterface;
// use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
// use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
// use Symfony\Component\HttpFoundation\Response;

// class DepartamentCrudController extends AbstractCrudController
// {

//     private $employeePositionRepository;

//     public function __construct(EmployeeRepository $employeePositionRepository)
//     {
//         $this->employeePositionRepository = $employeePositionRepository;
//     }



//     public static function getEntityFqcn(): string
//     {
//         return Departament::class;
//     }
// }

// src/Controller/Admin/DepartamentCrudController.php

namespace App\Controller\Admin;

use App\Entity\Departament;
use App\Entity\Employee;
use App\Entity\JobTitle;
use App\Repository\EmployeeRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\EntityManagerInterface;

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

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
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
