<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReservationController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/reservation', name: 'app_reservation')]
    public function reservation(Request $request, EntityManagerInterface $entityManager)
    {
        // if (!$this->getUser()) {
        //     $this->addFlash('danger', 'You need to connect to make a reservation.');
        //     return $this->redirectToRoute('app_login');
        // }

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //get date and time from form
            $dateForm = $form->getData()->getReservationDate();
            $timeForm = $form->getData()->getReservationTime();

            //find date and time from database reservation
            $findReservation = $this->entityManager->getRepository(Reservation::class)
                ->findOneBy(['reservationDate' => $dateForm, 'reservationTime' => $timeForm]);

            if ($findReservation) {
                $this->addFlash('danger', 'This time is already reserved. Please find another time or day.');
            } else {
                $reservation->setUser($this->getUser());
                $entityManager->persist($reservation);
                $entityManager->flush();
                //message
                $this->addFlash('success', 'Reservation made successfully!');
                return $this->redirectToRoute('app_reservation');
            }
        }

        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/account/reservation/cancel/{id}', name: 'app_reservation_cancel')]
    public function cancelReservation(ReservationRepository $reservationRepository, $id, Request $request): Response
    {
        // get reservation from database by id and remove it from user's reservation
        $reservationUser = $reservationRepository->findOneById($id);

        //security to verify  that the user owns this reservation
        if ($reservationUser) {
            if (!$this->getUser() || $reservationUser->getUser() !== $this->getUser()) {
                $this->addFlash('danger', 'You need to connect to make a reservation.');
                return $this->redirectToRoute('app_login');
            }

            $this->entityManager->remove($reservationUser);
            $this->entityManager->flush();
            $this->addFlash('success', 'Reservation canceled successfully!');
        } else {
            $this->addFlash('danger', 'Reservation not found.');
        }

        return $this->redirectToRoute('app_reservation');
    }
}