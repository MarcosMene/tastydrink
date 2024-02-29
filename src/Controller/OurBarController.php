<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OurBarController extends AbstractController
{
    #[Route('/our-bar', name: 'app_our_bar')]
    public function index(): Response
    {
        return $this->render('pages/our-bar.html.twig');
    }
}
