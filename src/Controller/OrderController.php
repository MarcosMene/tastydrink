<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    /**
     * chose address and carrier
     */
    #[Route('/order/delivery', name: 'app_order')]
    public function index(Cart $cart): Response
    {
        $addresses = $this->getUser()->getAddresses();

        if (count($addresses) == 0) {
            $this->addFlash(
                'danger',
                'You need to create an address to complet your order.'
            );
            return $this->redirectToRoute('app_account_address_form');
        }

        $form = $this->createForm(OrderType::class, null, [
            //to find only addresses of the connected user
            'addresses' => $addresses,
            'action' => $this->generateUrl('app_order_summary') //if form validate, send user to summary page
        ]);
        return $this->render('order/order.html.twig', [
            'deliveryForm' => $form->createView(),
            'cart' => $cart->getCart()
        ]);
    }

    #[Route('/order/summary', name: 'app_order_summary')]
    public function add(Request $request, Cart $cart, EntityManagerInterface $entityManager): Response
    {
        if ($request->getMethod() != 'POST') {
            return $this->redirectToRoute('app_cart');
        }

        //get information from cart
        $products = $cart->getCart();

        $form = $this->createForm(OrderType::class, null, [
            //to find only addresses of the connected user
            'addresses' => $this->getUser()->getAddresses(),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTime();

            //create address object from form data
            $addressObj = $form->get('addresses')->getData();

            $address = $addressObj->getFirstName() . ' ' . $addressObj->getLastName() . '<br/>';
            $address .= $addressObj->getAddress() . '<br/>';
            $address .= $addressObj->getPostal() . ' ' . $addressObj->getCity() . '<br/>';
            $address .= $addressObj->getCountry() . '<br/>';
            $address .= $addressObj->getPhone();

            // create order and set values
            $order = new Order();
            $reference = $date->format('dmY') . '-' . uniqid();
            $order->setReferenceOrder($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setState(1);
            $order->setCarrierName($form->get('carriers')->getData()->getName());
            $order->setCarrierPrice($form->get('carriers')->getData()->getPrice());
            $order->setDelivery($address);

            foreach ($products as $product) {
                $orderDetail = new OrderDetail();
                $orderDetail->setProductName($product['object']->getName());
                $orderDetail->setProductIllustration($product['object']->getIllustration());
                $orderDetail->setProductPrice($product['object']->getPrice());
                $orderDetail->setProductTva($product['object']->getTva());
                $orderDetail->setProductQuantity($product['qty']);
                $order->addOrderDetail($orderDetail);
            }

            $entityManager->persist($order);
            $entityManager->flush();
        }
        return $this->render('order/summary.html.twig', [
            'choices' => $form->getData(),
            'cart' => $products,
            'order' => $order,
            'totalWt' => $cart->getTotalWt()
        ]);
    }
}
