<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class AccountPasswordController extends AbstractController
{
    #[Route('/account/change-password', name: 'account_password')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $encoder): Response
    {
        $user = $this->getUser();
        assert($user instanceof User);

        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('old_password')->getData();

            if ($encoder->isPasswordValid($user, $old_pwd)) {
                $new_pwd = $form->get('new_password')->getData();
                $password = $encoder->hashPassword($user, $new_pwd);
                $user->setPassword($password);

                //set new password
                $user->setPassword($password);

                //upgrade password
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'Your  password has been changed successfully');
                return $this->redirectToRoute('account');
            } else {
                $this->addFlash('danger', 'Your  old password is incorrect. Please try again');
            }
        }


        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
