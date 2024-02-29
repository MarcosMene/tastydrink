<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MenuController extends AbstractController
{
    #[Route('/menu/drinks', name: 'menu_drinks')]
    public function drinks(): Response
    {
        return $this->render('pages/menu-drinks.html.twig');
    }
    #[Route('/menu/eats', name: 'menu_eats')]
    public function eats(): Response
    {
        return $this->render('pages/menu-eats.html.twig');
    }
}
