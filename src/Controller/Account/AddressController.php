<?php

namespace App\Controller\Account;

use App\Classe\Cart;
use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
                    'Your don\'t have permission to access it.'
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
    public function delete(AddressRepository $addressRepository,  $id): Response
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

        $this->entityManager->remove($address);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_account_address');
    }
}
