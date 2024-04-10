<?php

namespace App\Controller\Account;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/account/order/{id_order}', name: 'app_account_order')]
    public function index($id_order, OrderRepository $orderRepository): Response
    {

        //only order  owner can see the details of his orders
        $order = $orderRepository->findOneBy([
            "id" => $id_order,
            "user" => $this->getUser(),
        ]);

        if (!$order) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('account/order/index.html.twig', [
            'order' => $order,
        ]);
    }
}