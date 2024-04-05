<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    #[Route('/order/payment/{id_order}', name: 'app_payment')]
    public function index($id_order, OrderRepository $orderRepository, EntityManagerInterface $entityManager): Response
    {

        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        //find order and user on database by id to inject in stripe data and  check if the user is allowed to access this page
        $order = $orderRepository->findOneBy([
            'id' => $id_order,
            'user' => $this->getUser()
        ]);

        if (!$order) {
            return $this->redirectToRoute('app_home');
        }

        $products_for_stripe = [];

        foreach ($order->getOrderDetails() as $product) {
            //products information for stripe
            $products_for_stripe[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => number_format($product->getProductPriceWt(), 0, '', ''), //for stripe the number must be without , and .
                    'product_data' => [
                        'name' => $product->getProductName(),
                        'images' => [
                            $_ENV['DOMAIN'] . '/uploads/products/' . $product->getProductIllustration()
                        ]
                    ],
                ],
                'quantity' => $product->getProductQuantity(),
            ];
        }
        //carrier information for stripe
        $products_for_stripe[] = [
            'price_data' => [
                'currency' => 'usd',
                'unit_amount' => number_format($order->getCarrierPrice(), 0, '', ''), //for stripe the number must be without , and .
                'product_data' => [
                    'name' => 'Carrier company: ' . $order->getCarrierName(),
                ],
            ],
            'quantity' => 1,
        ];


        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'line_items' => [[
                $products_for_stripe
            ]],
            'mode' => 'payment',
            'success_url' => $_ENV['DOMAIN'] . '/order/thank-you/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $_ENV['DOMAIN'] . '/my-shopping/cancelation',
        ]);

        $order->setStripeSessionId($checkout_session->id);
        $entityManager->flush();

        return $this->redirect($checkout_session->url);
    }

    // id_order stripe 
    #[Route('/order/thank-you/{stripe_session_id}', name: 'app_payment_success')]
    public function success($stripe_session_id, OrderRepository $orderRepository, EntityManagerInterface $entityManager, Cart $cart): Response
    {
        //here you can send email to user to confirm  his order or do whatever you want after successful payment with neworder.html file. Same email method on registerController


        $order = $orderRepository->findOneBy([
            'stripe_session_id' => $stripe_session_id,
            'user' => $this->getUser()
        ]);

        //change state of order after payment accepted
        if ($order->getState() == 1) {
            $order->setState(2);

            //empty cart after purchase
            $cart->remove();
            $entityManager->flush();
        }

        return $this->render('payment/success.html.twig', [
            'order' => $order,
        ]);
    }
}
