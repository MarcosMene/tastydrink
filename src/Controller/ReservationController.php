<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Classe\MailReservation;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class ReservationController extends AbstractController
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

    //form from contact page
    #[Route('/reservation', name: 'app_reservation', methods: ['GET', 'POST'])]
    public function reservation(Request $request, EntityManagerInterface $entityManager)
    {

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //get date and time from form
            $dateForm = $form->get('reservationDate')->getData();
            $timeForm = $form->get('reservationTime')->getData();

            //convert the date to a string
            $dateString = $dateForm->format('Y-m-d');
            $hourString = $timeForm->format('H:i');

            //find date and time from database reservation
            $findReservation = $this->entityManager->getRepository(Reservation::class)
                ->findOneBy(['reservationDate' => $dateForm, 'reservationTime' => $timeForm]);

            if ($findReservation) {
                $this->addFlash('danger', 'This time is already reserved. Please find another time or day.');
            } else {

                //send email to Tasty Drink
                $mail = new MailReservation();
                $vars = [
                    "firstname" => $form->get('firstname')->getData(),
                    "lastname" => $form->get('lastname')->getData(),
                    "telephone" => $form->get('telephone')->getData(),
                    "number_of_people" => $form->get('numberOfPeople')->getData(),
                    "date" => $dateString,
                    "hour" => $hourString,
                    "comments" => $form->get('comments')->getData(),
                ];

                $mail->send('meneghettimarcos1@gmail.com', $form->get('firstname')->getData() . $form->get('lastname')->getData(), 'Reservation table at Tasty Drink Bar & Shop', 'reservationClient.html', $vars);

                //send email to Client
                $mail = new Mail();
                $mail->send($this->getUser()->getEmail(), 'Tasty Drink Bar & Shop', 'Your reservation is confirmed at Tasty Drink Bar&Shop', 'reservation.html', $vars);

                $reservation->setUser($this->getUser());
                $entityManager->persist($reservation);
                $entityManager->flush();
                //message
                $this->addFlash('success', 'Thank you ' . $form->get('firstname')->getData() . ' for your reservation. Have a great day!');
                return $this->redirectToRoute('app_reservation');
            }
        }
        return $this->render('pages/reservation.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //list of reservations on account page
    #[Route('/account/reservation', name: 'app_account_reservation')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();
        if (!$user) {
            $this->addFlash('danger', 'You don\'t have permission to do that.');
            return $this->redirectToRoute('app_login');
        }

        if ($user) {
            if (in_array('ROLE_ADMIN', $user->getRoles())) {
                return $this->redirectToRoute('app_account');
            } else {
                //find all reservation
                $reservations = $entityManager->getRepository(Reservation::class)->findAllOrderedByDateDescForUser($user->getId());

                //get today date to compare
                $today = new \DateTime();

                $reservationsWithStatus = array_map(function ($reservation) use ($today) {
                    $reservationDateTime = new \DateTime($reservation->getReservationDate()->format('Y-m-d') . ' ' . $reservation->getReservationTime()->format('H:i:s'));
                    return [
                        'reservation' => $reservation,
                        'isPast' => $reservationDateTime < $today,
                    ];
                }, $reservations);

                return $this->render('account/reservation/index.html.twig', [
                    'reservations' => $reservationsWithStatus,
                ]);
            }
        }
    }

    //route to modify
    #[Route('/account/modify-reservation/{id}', name: 'app_account_reservation_form')]
    public function edit($id, Request $request, ReservationRepository $reservationRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        //find reservation from database
        $reservation = $reservationRepository->find($id);

        if (!$reservation || $reservation->getUser() !== $user) {
            $this->addFlash('danger', 'Reservation not found.');
            return $this->redirectToRoute('app_account_reservation');
        }

        //get date and time from reservation
        $originalDateTime = new \DateTime($reservation->getReservationDate()->format('Y-m-d') . ' ' . $reservation->getReservationTime()->format('H:i:s'));

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        $newDateTime = new \DateTime($form->getData()->getReservationDate()->format('Y-m-d') . ' ' . $form->getData()->getReservationTime()->format('H:i:s'));
        if ($form->isSubmitted() && $form->isValid()) {

            //get date and time from form
            $dateForm = $form->get('reservationDate')->getData();
            $timeForm = $form->get('reservationTime')->getData();

            //convert the date to a string
            $dateString = $dateForm->format('Y-m-d');
            $hourString = $timeForm->format('H:i');

            if ($originalDateTime != $newDateTime) {
                $existingReservation = $reservationRepository->findOneBy([
                    'reservationDate' => $reservation->getReservationDate(),
                    'reservationTime' => $reservation->getReservationTime(),
                ]);

                if ($existingReservation && $existingReservation->getId() !== $reservation->getId()) {
                    $this->addFlash('danger', 'This time is already reserved. Please find another time or day.');
                } else {
                    //send email to Tasty Drink
                    $mail = new MailReservation();
                    $vars = [
                        "firstname" => $form->get('firstname')->getData(),
                        "lastname" => $form->get('lastname')->getData(),
                        "telephone" => $form->get('telephone')->getData(),
                        "number_of_people" => $form->get('numberOfPeople')->getData(),
                        "date" => $dateString,
                        "hour" => $hourString,
                        "comments" => $form->get('comments')->getData(),
                    ];

                    $mail->send('meneghettimarcos1@gmail.com', $form->get('firstname')->getData() . $form->get('lastname')->getData(), 'Reschedule my reservation at Dear Tasty Drink Bar & Shop', 'reservationModifyClient.html', $vars);

                    //send email to Client
                    $mail = new Mail();
                    $mail->send($this->getUser()->getEmail(), 'Tasty Drink Bar & Shop', 'Reschedule reservation at Tasty Drink Bar & Shop', 'reservationModify.html', $vars);
                    $entityManager->flush();
                    $this->addFlash('success', 'Reservation updated successfully.');
                    return $this->redirectToRoute('app_account_reservation');
                }
            } else {
                //send email to Tasty Drink
                $mail = new MailReservation();
                $vars = [
                    "firstname" => $form->get('firstname')->getData(),
                    "lastname" => $form->get('lastname')->getData(),
                    "telephone" => $form->get('telephone')->getData(),
                    "number_of_people" => $form->get('numberOfPeople')->getData(),
                    "date" => $dateString,
                    "hour" => $hourString,
                    "comments" => $form->get('comments')->getData(),
                ];

                $mail->send('meneghettimarcos1@gmail.com', $form->get('firstname')->getData() . $form->get('lastname')->getData(), 'Reschedule my reservation at Dear Tasty Drink Bar & Shop', 'reservationModifyClient.html', $vars);

                //send email to Client
                $mail = new Mail();
                $mail->send($this->getUser()->getEmail(), 'Tasty Drink Bar & Shop', 'Reschedule reservation at Tasty Drink Bar & Shop', 'reservationModify.html', $vars);
                $entityManager->flush();
                $this->addFlash('success', 'Reservation updated successfully.');
                return $this->redirectToRoute('app_account_reservation');
            }
        }
        return $this->render('account/reservation/form.html.twig', [
            'reservationForm' => $form->createView(),
        ]);
    }

    #[Route('/account/reservation/cancel/{id}', name: 'app_reservation_cancel', methods: ['POST'])]
    public function cancel(int $id, Request $request): Response
    {
        $user = $this->security->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        //find reservation
        $reservation = $this->entityManager->getRepository(Reservation::class)->find($id);

        //get date and time from form
        $dateForm = $reservation->getReservationDate();
        $timeForm = $reservation->getReservationTime();

        //convert the date to a string
        $dateString = $dateForm->format('Y-m-d');
        $hourString = $timeForm->format('H:i');

        if (!$reservation || $reservation->getUser() !== $user) {
            $this->addFlash('danger', 'Reservation not found.');
            return $this->redirectToRoute('app_account_reservation');
        }

        //security csrf
        $csrfToken = new CsrfToken('cancel' . $reservation->getId(), $request->request->get('_token'));
        if (!$this->csrfTokenManager->isTokenValid($csrfToken)) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        } else {
            $reservation->setCancelReservation(true);
            $this->addFlash('success', 'Your reservation was successfully canceled.');

            //send email to Tasty Drink
            $mail = new MailReservation();
            $vars = [
                "firstname" => $reservation->getFirstName(),
                "lastname" => $reservation->getLastName(),
                "telephone" => $reservation->getTelephone(),
                "number_of_people" => $reservation->getNumberOfPeople(),
                "date" => $dateString,
                "hour" => $hourString,
                "comments" => $reservation->getComments(),
            ];
            $mail->send('meneghettimarcos1@gmail.com', $reservation->getFirstName() . $reservation->getLastName(), 'Reservation table cancel at Tasty Drink Bar & Shop', 'reservationCancelClient.html', $vars);

            //send email to Client
            $mail = new Mail();
            $mail->send($this->getUser()->getEmail(), 'Tasty Drink Bar & Shop', 'Your reservation is cancel at Tasty Drink Bar&Shop', 'reservationCancel.html', $vars);

            $this->entityManager->flush();
        }


        return $this->redirectToRoute('app_account_reservation');
    }
}
