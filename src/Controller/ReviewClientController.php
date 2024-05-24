<?php

namespace App\Controller;

use App\Entity\ReviewClient;
use App\Form\ReviewClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReviewClientController extends AbstractController
{
    #[Route('/opinion-client', name: 'app_opinion_client')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reviewClient = new ReviewClient();

        $form = $this->createForm(ReviewClientType::class, $reviewClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reviewClient->setIsApproved(false);

            $reviewClient->setUser($this->getUser());
            $entityManager->persist($reviewClient);
            $entityManager->flush();
            //message
            $this->addFlash('success', 'Thank you for your opinion. We are glad to know about you.');
            return $this->redirectToRoute('app_opinion_client');
        }

        return $this->render('pages/opinion_client.html.twig', [
            'formOpinionClient' => $form->createView(),
        ]);
    }
}
