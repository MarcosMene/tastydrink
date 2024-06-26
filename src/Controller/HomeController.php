<?php

namespace App\Controller;

use App\Entity\BarTime;
use App\Entity\ShopTime;
use App\Repository\HeaderRepository;
use App\Repository\ProductRepository;
use App\Repository\ReviewClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HeaderRepository $headerRepository, ProductRepository $productRepository, EntityManagerInterface $entityManager, Request $request, ReviewClientRepository $reviewRepository): Response
    {

        //headers
        $headers = $headerRepository->findAllOrderedByAppear();



        //reviews
        $reviewsClientApproved = $reviewRepository->findBy(['isApproved' => true]);

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
            'headers' => $headers,
            'newProducts' => $newProducts,
            'barSchedules' => $barSchedules,
            'shopSchedules' => $shopSchedules,
            'reviewsClient' => $reviewsClientApproved
        ]);
    }
}
