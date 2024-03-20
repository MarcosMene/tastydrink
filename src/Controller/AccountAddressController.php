<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccountAddressController extends AbstractController
{
    #[Route('/account/addresses', name: 'account_address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    #[Route('/account/add-address', name: 'account_add_address')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // Save the address to the database
            $address->setUser($this->getUser());
            $entityManager->persist($address);
            $entityManager->flush();
            // Return to account page with a success message
            return $this->redirectToRoute('account_address');
        }
        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/account/modify-address/{id}', name: 'account_address_modify')]
    public function edit(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $address = $entityManager->getRepository(Address::class)->findOneById($id);

        if (!$address) {
            return $this->redirectToRoute('account_address');
        }

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('account_address');
        }

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/account/delete-address/{id}', name: 'account_address_delete')]
    public function delete(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $address = $entityManager->getRepository(Address::class)->findOneById($id);

        if ($address && $address->getUser() == $this->getUser()) {
            $entityManager->remove($address);
            $entityManager->flush();
        }

        return $this->redirectToRoute('account_address');
    }
}
