<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;

class AgeVerificationListener
{
  private $router;

  public function __construct(RouterInterface $router)
  {
    $this->router = $router;
  }

  public function onKernelRequest(RequestEvent $event)
  {
    $request = $event->getRequest();
    $session = $request->getSession();

    if (!$session->has('ageVerified') || !$session->get('ageVerified')) {
      if (!$request->isXmlHttpRequest()) {
        $event->setResponse(new RedirectResponse($this->router->generate('age_verification')));
      }
    }
  }
}
