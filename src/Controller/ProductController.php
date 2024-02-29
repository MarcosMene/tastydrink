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
        return $this->render('pages/our-products.html.twig');
    }

    #[Route('/product/{slug}', name: 'show')]
    public function show(): Response
    {
        return $this->render('pages/product.html.twig');
    }
}
