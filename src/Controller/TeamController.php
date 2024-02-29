<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TeamController extends AbstractController
{
    #[Route('/our-team', name: 'app_team')]
    public function index(): Response
    {
        return $this->render('pages/team.html.twig');
    }
}
