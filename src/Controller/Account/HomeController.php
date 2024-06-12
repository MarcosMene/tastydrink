<?php

namespace App\Controller\Account;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(OrderRepository $orderRepository): Response
    {
        // $orders = $orderRepository->findBy([
        //     'user' => $this->getUser(),
        //     'state' => [2, 3], // Completed orders and  Delivered orders
        // ]);
        //show desc and only paid orders
        $orders = $orderRepository->findSuccessOrders($this->getUser());

        // dd($orders);

        return $this->render('account/index.html.twig', [
            'orders' => $orders
        ]);
    }
}
