<?php

namespace App\Controller\Account;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class WishlistController extends AbstractController
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





  #[Route('/account/wishlist', name: 'app_account_wishlist')]
  public function index(): Response
  {
    // Check if the user is logged in and redirect based on role
    $user = $this->getUser();

    if ($user) {
      if (in_array('ROLE_ADMIN', $user->getRoles())) {
        return $this->redirectToRoute('app_account');
      } else {
        return $this->render('account/wishlist/index.html.twig');
      }
    }
  }

  #[Route('/account/wishlist/add/{id}', name: 'app_account_wishlist_add')]
  public function add(ProductRepository $productRepository, EntityManagerInterface $entityManager, $id, Request $request): Response
  {
    // get product from database by id
    $product = $productRepository->findOneById($id);

    //if product exist, add to database
    if ($product) {
      $this->getUser()->addWishlist($product);
    }

    $entityManager->flush();
    //message
    $this->addFlash('success', 'The product has been add to your wishlist.');

    // back to last page visited 
    return $this->redirect($request->headers->get('referer'));
  }

  #[Route('/account/wishlist/remove/{id}', name: 'app_account_wishlist_remove')]
  public function remove(ProductRepository $productRepository, EntityManagerInterface $entityManager, $id, Request $request): Response
  {
    // get product from database by id and remove it from user's wishlist
    $product = $productRepository->findOneById($id);

    //if product exist, delete from database
    if ($product) {

      //security csrf
      $csrfToken = new CsrfToken('deleteWishlist' . $product->getId(), $request->request->get('_token'));
      if (!$this->csrfTokenManager->isTokenValid($csrfToken)) {
        throw $this->createAccessDeniedException('Invalid CSRF token.');
      }
      $this->getUser()->removeWishlist($product);
      $entityManager->flush();
      $this->addFlash(
        'success',
        'Your product has been successfully delete from your wishlist.'
      );
    } else {
      $this->addFlash(
        'danger',
        'This product doesn\'t exist.'
      );
    }
    // back to last page visited 
    return $this->redirect($request->headers->get('referer'));
  }
}
