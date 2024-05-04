<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class InvoiceController extends AbstractController
{

  // route account that allow user to see their invoices.
  #[Route('/account/invoice/print/{id_order}', name: 'app_invoice_customer')]
  public function invoice_customer(OrderRepository $orderRepository, $id_order): Response
  {
    // find order by  id 
    $order = $orderRepository->findOneById($id_order);

    if (!$order) return $this->redirectToRoute('app_account');

    // verify if user is  the owner of this invoice 
    if ($order->getUser() != $this->getUser()) {
      return $this->redirectToRoute('app_account');
    }

    // instantiate and use the dompdf class
    $dompdf = new Dompdf();

    $html = $this->renderView('invoice/index.html.twig', [
      'order' => $order,
    ]);  // The file to convert to PDF

    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    $dompdf->stream('facture.pdf', [
      "Attachment" => false,  # Keep this as false for the pdf to stream in the browser
    ]);
    exit();
  }

  // route account that allow admin to see invoices from users.
  #[Route('/admin/invoice/print/{id_order}', name: 'app_invoice_admin')]
  public function invoice_admin(OrderRepository $orderRepository, $id_order): Response
  {
    // find order by  id 
    $order = $orderRepository->findOneById($id_order);

    if (!$order) return $this->redirectToRoute('admin');

    // instantiate and use the dompdf class
    $dompdf = new Dompdf();

    $html = $this->renderView('invoice/index.html.twig', [
      'order' => $order,
    ]);  // The file to convert to PDF

    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    $dompdf->stream('facture.pdf', [
      "Attachment" => false,  # Keep this as false for the pdf to stream in the browser
    ]);

    exit();
  }
}
