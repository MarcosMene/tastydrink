<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Product;
use App\Entity\Review;
use App\Form\ReviewType;
use App\FormFilter\SearchForm;
use App\Repository\ProductRepository;
use App\Repository\ReviewRepository;
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

    #[Route('/our-products', name: 'app_products')]
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
        return $this->render('products/our-products.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'min' => $min,
            'max' => $max,
        ]);
    }

    #[Route('/product/{slug}', name: 'app_product')]
    public function show($slug, ProductRepository $productRepository, Request $request, ReviewRepository $reviewRepository, Product $productreview): Response
    {
        $user = $this->getUser();

        //   PRODUCT 
        $product = $productRepository->findOneBySlug($slug);
        if (!$product) {
            return $this->redirectToRoute('app_products');
        }

        // REVIEW 
        //find user review 
        $review = $reviewRepository->findOneBy(['product' => $product, 'user' => $this->getUser()]);

        //find other reviews
        $reviews = $reviewRepository->findApprovedReviewsByProduct($product->getId());


        $review = new Review();
        $formReview = $this->createForm(ReviewType::class, $review);
        $formReview->handleRequest($request);

        if ($formReview->isSubmitted() && $formReview->isValid()) {
            $review->setIsApproved(false);
            $review->setProduct($product);
            $review->setUser($this->getUser());

            $this->em->persist($review);
            $this->em->flush();

            $this->addFlash('success', 'Your review has been submitted successfully. Thank you very much.');
            return $this->redirectToRoute('app_product', ['slug' => $slug]);
        }
        return $this->render('products/show.html.twig', [
            'product' => $product,
            'productSuggestions' => $productRepository->findByIsSuggestion(true, ['id' => 'DESC'], 3),
            'formReview' => $formReview->createView(),
            // 'averageRate' => $averageRate,
            'user_reviewed' => $reviewRepository->findOneBy(['product' => $product, 'user' => $user]) !== null,
            'reviews' => $reviews,
        ]);
    }
}
