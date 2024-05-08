<?php

namespace App\Controller;

use App\Classe\MailContact;
use App\DTO\ContactDTO;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mail = new MailContact();
            $vars = [
                "firstname" => $form->get('firstName')->getData(),
                "lastname" => $form->get('lastName')->getData(),
                "email" => $form->get('email')->getData(),
                "subject" => $form->get('subject')->getData(),
                "message" => $form->get('message')->getData(),
            ];


            $mail->send('meneghettimarcos1@gmail.com', $form->get('firstName')->getData() . $form->get('lastName')->getData(), $form->get('subject')->getData(), 'contact.html', $vars);
            //message
            $this->addFlash('success', 'Thank you ' . $form->get('firstName')->getData() . ' for contacting us. We appreciate your interest and will get back to you as soon as possible. Have a great day!');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('pages/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
