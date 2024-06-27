<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TermConditionsController extends AbstractController
{
    #[Route('/term-conditions', name: 'app_term_conditions')]
    public function index(): Response
    {
        return $this->render('pages/termConditions.html.twig');
    }
}
