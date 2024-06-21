<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AgeVerificationController extends AbstractController
{
    #[Route('/age-verification', name: 'app_age_verification')]
    public function index(SessionInterface $session): Response
    {
        return $this->render('_partials/ageVerification/index.html.twig');
    }

    #[Route('/verify-age', name: 'app_verify_age', methods: ['POST'])]
    public function verifyAge(Request $request, SessionInterface $session): Response
    {
        if ($request->request->get('age') >= 18) {
            $session->set('ageVerified', true);
            return $this->redirectToRoute('app_home');
        }
        return $this->redirectToRoute('app_age_verification');
    }
}
