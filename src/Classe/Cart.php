<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{

  private $session;

  public function __construct(RequestStack $session)
  {
    $this->session = $session;
  }

  public function add($id)
  {
    $session = $this->session->getSession();

    $cart = $session->get('cart', []);


    if (!empty($cart[$id])) {
      $cart[$id]++;
    } else {
      $cart[$id] = 1;
    }

    $session->set('cart', $cart);
  }

  public function get()
  {
    $methodget = $this->session->getSession();
    return $methodget->get('cart');
  }
  public function remove()
  {
    $methodget = $this->session->getSession();
    return $methodget->remove('cart');
  }
}
