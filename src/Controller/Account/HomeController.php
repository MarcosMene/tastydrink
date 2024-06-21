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
        // Check if the user is logged in and redirect based on role
        $user = $this->getUser();

        if ($user) {
            if (in_array('ROLE_ADMIN', $user->getRoles())) {
                return $this->render('account/index.html.twig');
            } else {
                $orders = $orderRepository->findSuccessOrders($this->getUser());

                return $this->render('account/index.html.twig', [
                    'orders' => $orders
                ]);
            }
        }
    }
}
