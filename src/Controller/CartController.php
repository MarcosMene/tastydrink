<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/my-shopping/{reason}', name: 'app_cart', defaults: ['reason' => null])]
    public function index(Cart $cart, $reason): Response
    {
        if ($reason == "cancelation") {
            $this->addFlash(
                'danger',
                'Payment canceled: you can update your cart and order. If the problem persists please contact us.'
            );
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getCart(),
            'totalWt' => $cart->getTotalWt()
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, Cart $cart, ProductRepository $productRepository, Request $request): Response
    {
        $product = $productRepository->findOneById($id);
        $cart->add($product);

        //message
        $this->addFlash('success', 'The product has been add to your shopping cart.');

        // back to last page visited 
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/cart/decrease/{id}', name: 'app_cart_decrease')]
    public function decrease($id, Cart $cart): Response
    {
        $cart->decrease($id);
        if (count($cart->getCart()) == 0) {
            //message
            $this->addFlash('danger', 'You don\'t have any product in your shopping cart.');
        } else {
            //message
            $this->addFlash('success', 'The product has been deleted from your shopping cart.');
        }
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/delete/{id}', name: 'app_cart_delete')]
    public function delete($id, Cart $cart): Response
    {
        $cart->delete($id);

        //message
        $this->addFlash('success', 'The product has been deleted from your shopping cart.');

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove', name: 'app_cart_remove')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        //message
        $this->addFlash('danger', 'All products have been deleted from your shopping cart.');
        return $this->redirectToRoute('app_cart');
    }
}
