<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
  public function __construct(private RequestStack $requestStack)
  {
  }

  /**
   * add()
   * function add product into the shopping cart.
   */

  public function add($product)
  {
    //call session symfony
    $cart = $this->getCart();
    //add quantity to the product
    if (isset($cart[$product->getId()])) {
      $cart[$product->getId()] = [
        'object' => $product,
        'qty' => $cart[$product->getId()]['qty'] + 1
      ];
    } else {
      $cart[$product->getId()] = [
        'object' => $product,
        'qty' => 1
      ];
    }

    // create session cart 
    $this->requestStack->getSession()->set('cart', $cart);
  }

  /**
   * decrease()
   *
   *function that decrease product from the shopping cart
   */
  public function decrease($id)
  {
    $cart = $this->getCart();

    //if product  is in the cart and more than one , we can decrease the quantity
    if ($cart[$id]['qty'] > 1) {
      $cart[$id]['qty'] = $cart[$id]['qty'] - 1;

      //if product is less than one, delete product from the cart
    } else {
      unset($cart[$id]);
    }

    //update  the session with the new data
    $this->requestStack->getSession()->set('cart', $cart);
  }

  //verify total products  in the shopping cart
  public function fullQuantity()
  {
    $cart = $this->getCart();
    $quantity = 0;

    if (!isset($cart)) {
      return $quantity;
    }

    foreach ($cart as $product) {

      $quantity += $product['qty'];
    }
    return $quantity;
  }

  public function getTotalWt()
  {
    $cart = $this->getCart();
    $price = 0;

    if (!isset($cart)) {
      return $price;
    }

    foreach ($cart as $product) {
      $price = $price + ($product['object']->getPriceWt() * $product['qty']);
    }

    return $price;
  }



  /**
   * remove()
   * remove all items from the list of products in the shopping cart.
   */

  public function remove()
  {
    return $this->requestStack->getSession()->remove('cart');
  }


  public function getCart()
  {
    return $this->requestStack->getSession()->get('cart');
  }
}