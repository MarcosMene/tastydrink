<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Product;
use App\Repository\HeaderRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HeaderRepository $headerRepository, ProductRepository $productRepository): Response
    {
        $newProducts = $productRepository->findBy([], ['id' => 'DESC'], 3);


        return $this->render('pages/home.html.twig', [
            'headers' => $headerRepository->findAll(),
            // 'productSuggestions' => $productRepository->findByIsSuggestion(true, ['id' => 'DESC'], 3),
            'newProducts' => $newProducts,
        ]);
    }
}
