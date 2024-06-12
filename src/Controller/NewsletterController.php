<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Repository\NewsletterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsletterController extends AbstractController
{

    #[Route('/subscribe-form', name: 'app_subscribe', methods: ['POST'])]
    public function subscribe(Request $request, EntityManagerInterface $entityManager, NewsletterRepository $newsletterRepository): Response
    {
        //newsletter
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if email already exists
            $existingSubscriber = $newsletterRepository->findOneBy(['email' => $newsletter->getEmail()]);

            if ($existingSubscriber) {
                $this->addFlash('danger', 'This email already exists.');
            } else {
                $newsletter->setCreatedAt(new \DateTime());
                $entityManager->persist($newsletter);
                $entityManager->flush();

                $mail = new Mail();
                $mail->send($newsletter->getEmail(), 'Tasty Drink Bar & Shop', 'Confirmation newsletter', 'newsletter.html');

                $this->addFlash('success', 'You have successfully subscribed to the newsletter!');
            }
            // back to last page visited 
            return $this->redirect($request->headers->get('referer'));
        }
        return $this->render('_partials/newsletter/subscribe.html.twig', [
            'formNewsletter' => $form->createView(),
        ]);
    }
}
