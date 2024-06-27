<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PrivacyPolicyController extends AbstractController
{
    #[Route('/privacy-policy', name: 'app_privacy_policy')]
    public function index(): Response
    {
        return $this->render('pages/privacyPolicy.html.twig', [
            'controller_name' => 'PrivacyPolicyController',
        ]);
    }
}
