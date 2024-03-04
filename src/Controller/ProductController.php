<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/our-products/{slug}', name: 'product')]
    public function index(): Response
    {
        return $this->render('products/our-products.html.twig');
    }

    #[Route('/product/{slug}', name: 'show')]
    public function show(): Response
    {
        return $this->render('products/product.html.twig');
    }
}
