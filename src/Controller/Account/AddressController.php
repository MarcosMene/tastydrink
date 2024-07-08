<?php

namespace App\Controller\Account;

use App\Classe\Cart;
use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class AddressController extends AbstractController
{
    private $entityManager;
    private $security;
    private $csrfTokenManager;

    public function __construct(EntityManagerInterface $entityManager, Security $security,  CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    #[Route('/account/addresses', name: 'app_account_address')]
    public function index(): Response
    {
        // Check if the user is logged in and redirect based on role
        $user = $this->getUser();

        if ($user) {
            if (in_array('ROLE_ADMIN', $user->getRoles())) {
                return $this->redirectToRoute('app_account');
            } else {
                return $this->render('account/address/index.html.twig');
            }
        }
    }

    //route to create and modify address
    #[Route('/account/add-address/{id}', name: 'app_account_address_form', defaults: ['id' => null])]
    public function form(Request $request, $id, AddressRepository $addressRepository, Cart $cart): Response
    {
        if ($id) {
            $address = $addressRepository->findOneById($id);

            //security to verify  that the user owns this adress
            if (!$address or $address->getUser() != $this->getUser()) {
                $this->addFlash(
                    'danger',
                    'This page doesn\'t exist.'
                );
                return $this->redirectToRoute('app_account_address');
            }
        } else {
            $address = new Address();
            $address->setUser($this->getUser());
        }

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save the user address to the database 
            $this->entityManager->persist($address);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                'Your address has been successfully added.'
            );

            //if cart is not empty, redirect to app_order
            if ($cart->fullQuantity() > 0) {
                return $this->redirectToRoute('app_order');
            }

            // Return to account page with a success message
            return $this->redirectToRoute('app_account_address');
        }
        return $this->render('account/address/form.html.twig', [
            'addressForm' => $form->createView(),
        ]);
    }

    #[Route('/account/delete-address/{id}', name: 'app_account_address_delete')]
    public function delete(AddressRepository $addressRepository,  $id, Request $request): Response
    {
        $address = $addressRepository->findOneById($id);

        //security to verify  that the user owns this adress
        if (!$address or $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_account_address');
        }

        $this->addFlash(
            'success',
            'Your address has been deleted successfully!'
        );

        // // Validate CSRF token to delete an address
        // $csrfToken = new CsrfToken('deleteAddress' . $address->getId(), $request->request->get('_token'));
        // if ($this->isCsrfTokenValid('deleteAddress' . $id, $request->query->get('_token'))) {
        //     $this->entityManager->remove($address);
        //     $this->entityManager->flush();
        // } else {
        //     $this->addFlash('danger', 'You don\'t have access to it.');
        // }

        //security csrf
        $csrfToken = new CsrfToken('deleteAddress' . $id, $request->request->get('_token'));
        if (!$this->csrfTokenManager->isTokenValid($csrfToken)) {
            // throw $this->createAccessDeniedException('Invalid CSRF token.');
            $this->addFlash('danger', 'You don\'t have access to it.');
        } else {
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_account_address');
    }
}
