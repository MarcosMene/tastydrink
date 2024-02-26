<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductDetailController extends AbstractController
{
    #[Route('/product/{id}', name: 'product')]
    public function index(): Response
    {
        return $this->render('product/show.html.twig');
    }
}
