<?php

namespace App\Controller;

use App\DTO\ContactDTO;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $data = new ContactDTO();

        $form = $this->createForm(ContactType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // send mail
                $mail = (new TemplatedEmail())
                    ->to('contact@tastydrink.fr')
                    ->from($data->email)
                    ->subject('Contact request')
                    ->htmlTemplate('emails/contact.html.twig')
                    ->context(["data" => $data]);

                $mailer->send($mail);
                $this->addFlash('success', 'Your  message has been sent successfully');
                return $this->redirectToRoute('contact');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Impossible to send your email');
            }
        }
        return $this->render('pages/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
