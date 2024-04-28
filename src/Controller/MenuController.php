<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MenuController extends AbstractController
{
    #[Route('/menu/drinks', name: 'app_menu_drinks')]
    public function drinks(): Response
    {
        return $this->render('pages/menu-drinks.html.twig');
    }
    #[Route('/menu/foods', name: 'app_menu_foods')]
    public function eats(): Response
    {
        return $this->render('pages/menu-foods.html.twig');
    }
}
