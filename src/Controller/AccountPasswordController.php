<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccountPasswordController extends AbstractController
{
    #[Route('/account/password', name: 'app_account_password')]
    public function index(): Response
    {
        return $this->render('account_password/index.html.twig', [
            'controller_name' => 'AccountPasswordController',
        ]);
    }
}
