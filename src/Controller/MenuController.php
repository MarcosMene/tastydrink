<?php

namespace App\Controller;

use App\Repository\DrinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MenuController extends AbstractController
{
    #[Route('/menu/drinks', name: 'app_menu_drinks')]
    public function drinks(DrinkRepository $drinkRepository): Response
    {
        $drink = $drinkRepository->findAll();


        return $this->render('pages/menu-drinks.html.twig', [
            'drinks' => $drink,
        ]);
    }
    #[Route('/menu/foods', name: 'app_menu_foods')]
    public function eats(): Response
    {
        return $this->render('pages/menu-foods.html.twig');
    }
    #[Route('/menu/desserts', name: 'app_menu_desserts')]
    public function desserts(): Response
    {
        return $this->render('pages/menu-desserts.html.twig');
    }
}
