<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\SignUpType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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

            //create token to confirm email
            $token = bin2hex(random_bytes(15));
            $user->setToken($token);
            $user->setTokenExpireAt(new \DateTime('+10 minutes'));

            $entityManager->persist($user);
            $entityManager->flush();

            // //message
            // $this->addFlash('success', 'Your account was  created successfully! You can now log in.');

            //send email to user to confirm sign up
            $mail = new Mail();
            $vars = [
                //gererate token on the url
                "link" => $this->generateUrl('app_confirm_email', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL),
                "firstname" => $user->getFirstname(),
                "lastname" => $user->getLastname(),
            ];
            $mail->send($user->getEmail(), $user->getFirstName() . ' ' . $user->getLastName(), 'Welcome to Tasty Drink Bar & Shop', 'confirmConnection.html', $vars);

            return $this->redirectToRoute('app_check_email');
        }
        return $this->render('signup/index.html.twig', [
            'registerForm' => $form->createView()
        ]);
    }

    #[Route('/confirm-email/{token}', name: 'app_confirm_email')]
    public function confirmEmail(string $token, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->findOneBy(['token' => $token]);

        if (!$user || $user->getTokenExpireAt() < new \DateTime()) {
            $this->addFlash('danger', 'Token is invalid or expired.');
            return $this->redirectToRoute('app_login');
        }

        $user->setIsConfirmed(true);
        $user->setToken(null);
        $user->setTokenExpireAt(null);
        $entityManager->flush();

        $this->addFlash('success', 'Email confirmed, you can now login.');
        return $this->redirectToRoute('app_login');
    }

    #[Route('/check-email', name: 'app_check_email')]
    public function checkEmail(): Response
    {
        return $this->render('signup/check_email.html.twig');
    }
}
