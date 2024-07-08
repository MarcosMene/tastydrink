<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

class LoginRefererListener
{
  private $requestStack;
  private $router;

  public function __construct(RequestStack $requestStack, RouterInterface $router)
  {
    $this->requestStack = $requestStack;
    $this->router = $router;
  }

  public function onKernelRequest(RequestEvent $event)
  {
    $request = $event->getRequest();
    $session = $this->requestStack->getSession();

    if ($request->attributes->get('_route') === 'app_login') {
      $referer = $request->headers->get('referer');
      if ($referer) {
        $session->set('login_referer', $referer);
      }
    }
  }
}
