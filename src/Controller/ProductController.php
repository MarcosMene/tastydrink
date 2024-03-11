<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/our-products', name: 'app_products')]
    public function index(): Response
    {
        $products = $this->em->getRepository(Product::class)->findAll();
        // dd($products);
        return $this->render('products/our-products.html.twig', [
            'products' => $products
        ]);
    }
}