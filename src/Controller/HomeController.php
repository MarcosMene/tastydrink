<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\BarTime;
use App\Entity\Newsletter;
use App\Entity\Product;
use App\Entity\ShopTime;
use App\Form\NewsletterType;
use App\Repository\HeaderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HeaderRepository $headerRepository, ProductRepository $productRepository, EntityManagerInterface $entityManager, Request $request): Response
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


        //newsletter
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($newsletter);
            $entityManager->flush();

            $mail = new Mail();
            $mail->send($newsletter->getEmail(), 'Tasty Drink User', 'Confirmation newsletter', 'newsletter.html');

            $this->addFlash('success', 'Your have successfully subscribed to our newsletter');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pages/home.html.twig', [
            'headers' => $headerRepository->findAll(),
            // 'productSuggestions' => $productRepository->findByIsSuggestion(true, ['id' => 'DESC'], 3),
            'newProducts' => $newProducts,
            'barSchedules' => $barSchedules,
            'shopSchedules' => $shopSchedules,
            'NewsletterForm' => $form->createView()
        ]);
    }
}
