<?php

namespace App\Controller;

use App\Repository\DepartamentRepository;
use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TeamController extends AbstractController
{
    #[Route('/our-team', name: 'app_team')]
    public function index(EmployeeRepository $employeeRepository, DepartamentRepository $departamentRepository): Response
    {
        $employee = $employeeRepository->findAll();
        $department = $departamentRepository->findAll();

        return $this->render('pages/team.html.twig', [
            "employees" => $employee,
            "departments" => $department
        ]);
    }
}
