<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Form\ForgotPasswordFormType;
use App\Form\ResetPasswordFormType;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ForgotPasswordController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/forgot-password', name: 'app_forgot_password')]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $form = $this->createForm(ForgotPasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //get email data from form
            $email = $form->get('email')->getData();

            //get user email from database 
            $user = $userRepository->findOneByEmail($email);

            //send message to user
            $this->addFlash('success', 'If your email address exists, you will receive an email to reset your password.');

            //if user exist, reset password and send by email the new password
            if ($user) {

                //create the token to store in database
                $token = bin2hex(random_bytes(15));
                $user->setToken($token);

                //duration of token
                $date = new DateTime();
                $date->modify("+10 minutes");

                $user->setTokenExpireAt($date);

                $this->em->flush();

                //send email to user to confirm sign up
                $mail = new Mail();
                $vars = [
                    //gererate token on the url
                    "link" => $this->generateUrl('app_password_reset', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL),
                ];
                $mail->send($user->getEmail(), $user->getFirstName() . ' ' . $user->getLastName(), 'Changing your password in Tasty Drink Bar & Shop', 'forgotpassword.html', $vars);
            }
        }
        return $this->render('forgot_password/index.html.twig', [
            'forgotPasswordForm' => $form->createView()
        ]);
    }

    #[Route('/password/reset/{token}', name: 'app_password_reset')]
    public function reset(Request $request,  UserRepository $userRepository, $token): Response
    {
        if (!$token) {
            return $this->redirectToRoute('app_forgot_password');
        }

        //find user with the token and check if token is expired
        $user = $userRepository->findOneByToken($token);

        //get time now
        $now = new DateTime();

        if (!$user || $now > $user->getTokenExpireAt()) {
            return $this->redirectToRoute('app_forgot_password');
        }
        //$user is from data_class ResetPasswordFormType
        $form = $this->createForm(ResetPasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //empty settoken
            $user->setToken(null);
            $user->setTokenExpireAt(null);

            $this->em->flush();
            $this->addFlash('success', 'Your password has been updated correctly');
            return $this->redirectToRoute('app_login');
        }
        return $this->render(
            'forgot_password/reset.html.twig',
            [
                'resetForm' => $form->createView()
            ]
        );
    }
}
