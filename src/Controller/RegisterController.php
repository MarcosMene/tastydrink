<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route('/sign-up', name: 'app_sign-up')]
    public function index(): Response
    {
        return $this->render('signup/index.html.twig');
    }
}
