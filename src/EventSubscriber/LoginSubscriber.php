<?php

namespace App\EventSubscriber;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class LoginSubscriber implements EventSubscriberInterface
{

  private $em;
  private $security;

  public function __construct(Security $security, EntityManagerInterface $em)
  {
    $this->em = $em;
    $this->security = $security;
  }

  public function onLogin()
  {
    //code to update the date of last connection
    $user = $this->security->getUser();
    $user->setLastLoginAt(new DateTime());
    $this->em->flush();
  }

  public static function getSubscribedEvents(): array
  {
    // return the subscribed events, their methods and priorities
    return [
      LoginSuccessEvent::class => 'onLogin'
    ];
  }
}
