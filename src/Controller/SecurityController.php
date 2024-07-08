<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;

class SecurityController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }


    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        // if a user is already logged in, redirect to the dashboard
        if ($this->getUser()) {
            return $this->redirectToRoute('admin');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/login_check', name: 'app_login_check')]
    public function loginCheck(UserAuthenticatorInterface $userAuthenticator, FormLoginAuthenticator $formLoginAuthenticator): Response
    {
        // Get the referer from session
        $session = $this->requestStack->getSession();
        $referer = $session->get('login_referer');

        // Clear the referer from session
        $session->remove('login_referer');

        // Check if referer is the reservation page
        if ($referer && strpos($referer, $this->generateUrl('app_reservation')) !== false) {
            return $this->redirectToRoute('app_reservation');
        }

        // Default to dashboard
        return $this->redirectToRoute('app_account');
    }

    #[Route(path: '/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): never
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
