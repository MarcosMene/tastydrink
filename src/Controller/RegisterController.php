<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\SignUpType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route('/sign-up', name: 'app_sign-up')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(SignUpType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            //hashpassword
            $user->setPassword(
                $encoder->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            //message
            $this->addFlash('success', 'Your account was  created successfully! You can now log in.');

            //send email to user to confirm sign up
            $mail = new Mail();
            $vars = [
                "firstname" => $user->getFirstname(),
                "lastname" => $user->getLastname(),
            ];
            $mail->send($user->getEmail(), $user->getFirstName() . ' ' . $user->getLastName(), 'Welcome to Tasty Drink Bar & Shop', 'welcome.html', $vars);

            return $this->redirectToRoute('app_login');
        }
        return $this->render('signup/index.html.twig', [
            'registerForm' => $form->createView()
        ]);
    }
}
