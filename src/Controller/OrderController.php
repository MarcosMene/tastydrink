<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'order')]
    public function index(): Response
    {
        return $this->render('shopping_cart/order.html.twig');
    }
    #[Route('/order/summary', name: 'summary')]
    public function summary(): Response
    {
        return $this->render('shopping_cart/summary.html.twig');
    }
}
