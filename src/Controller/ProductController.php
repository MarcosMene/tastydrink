<?php

namespace App\Controller;

use App\Classe\Search;
use App\Data\SearchData;
use App\Entity\Product;
use App\Form\SearchType;
use App\FormFilter\SearchForm;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/our-products', name: 'products')]
    public function index(ProductRepository $repository, Request $request): Response
    {
        // CREATE FORM TO FIND A PRODUCT 
        $data = new SearchData();

        // PAGINATION  
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);

        //find min/max value of price
        [$min, $max] = $repository->findMinMax($data);

        $products = $repository->findSearch($data);
        if ($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('_partials/_products.html.twig', ['products' => $products]),
                'sorting' => $this->renderView('_partials/_sorting.html.twig', ['products' => $products]),
                'pagination' => $this->renderView('_partials/_pagination.html.twig', ['products' => $products]),
                'min' => $min,
                'max' => $max
            ]);
        }
        return $this->render('products/our-products.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'min' => $min,
            'max' => $max,
        ]);
    }


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
