<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\BarTime;
use App\Entity\Product;
use App\Entity\ShopTime;
use App\Repository\HeaderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HeaderRepository $headerRepository, ProductRepository $productRepository, EntityManagerInterface $entityManager): Response
    {

        //schedule of the bar
        $barSchedules = $entityManager
            ->getRepository(BarTime::class)
            ->findAll();

        //schedule of the shop
        $shopSchedules = $entityManager
            ->getRepository(ShopTime::class)
            ->findAll();



        // show the 3 new products in home page
        $newProducts = $productRepository->findBy([], ['id' => 'DESC'], 3);


        return $this->render('pages/home.html.twig', [
            'headers' => $headerRepository->findAll(),
            // 'productSuggestions' => $productRepository->findByIsSuggestion(true, ['id' => 'DESC'], 3),
            'newProducts' => $newProducts,
            'barSchedules' => $barSchedules,
            'shopSchedules' => $shopSchedules,
        ]);
    }
}