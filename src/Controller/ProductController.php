<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    // #[Route('/our-products', name: 'products')]
    // public function index(Request $request): Response
    // {
    //     $search = new Search();
    //     $form = $this->createForm(SearchType::class, $search);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {

    //         $products = $this->em->getRepository(Product::class)->findWithSearch($search);
    //     } else {
    //         $products = $this->em->getRepository(Product::class)->findAll();
    //     }

    //     return $this->render('products/our-products.html.twig', [
    //         'products' => $products,
    //         'form' => $form->createView()
    //     ]);
    // }


    #[Route('/product/{slug}', name: 'app_product')]

    public function show($slug, ProductRepository $productRepository): Response
    {

        $product = $productRepository->findOneBySlug($slug);
        if (!$product) {
            return $this->redirectToRoute('app_shop');
        }

        return $this->render('products/show.html.twig', [
            'product' => $product,
            'productSuggestions' => $productRepository->findByIsSuggestion(true, ['id' => 'DESC'], 3),
        ]);
    }
}
