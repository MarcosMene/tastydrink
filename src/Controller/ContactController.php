<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Classe\MailContact;
use App\Form\ContactType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        $date = new DateTime('now');

        if ($form->isSubmitted() && $form->isValid()) {

            //send email to Tasty Drink
            $mail = new MailContact();
            $vars = [
                "firstname" => $form->get('firstName')->getData(),
                "lastname" => $form->get('lastName')->getData(),
                "email" => $form->get('email')->getData(),
                "telephone" => $form->get('telephone')->getData(),
                "subject" => $form->get('subject')->getData(),
                "message" => $form->get('message')->getData(),
                "date" => $date->format('Y')
            ];

            $mail->send('meneghettimarcos1@gmail.com', $form->get('firstName')->getData() . $form->get('lastName')->getData(), $form->get('subject')->getData(), 'contact.html', $vars);
            //message
            $this->addFlash('success', 'Thank you ' . $form->get('firstName')->getData() . ' for contacting us. We appreciate your interest and will get back to you as soon as possible. Have a great day!');

            //send email to client
            $mail = new Mail();
            $mail->send($form->get('email')->getData(), 'Tasty Drink Bar & Shop', 'We received your contact at Tasty Drink Bar&Shop', 'contactClient.html', $vars);


            return $this->redirectToRoute('app_contact');
        }
        return $this->render('pages/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
