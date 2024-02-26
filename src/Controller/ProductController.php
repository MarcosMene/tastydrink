<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/our-products', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig');
    }

    #[Route('/our-product/{slug}', name: 'show')]
    public function show(): Response
    {
        return $this->render('product/show.html.twig');
    }
}
