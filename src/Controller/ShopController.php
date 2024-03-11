<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShopController extends AbstractController
{


    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/shop', name: 'shop')]
    public function index(): Response
    {
        $products = $this->em->getRepository(Product::class)->findAll();
        return $this->render('shop/shop.html.twig', [
            'products' => $products
        ]);
    }
}
