<?php

namespace App\Twig;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use Symfony\Component\Form\FormFactoryInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SubscribeExtension extends AbstractExtension
{
  private $formFactory;


  public function __construct(FormFactoryInterface $formFactory)
  {
    $this->formFactory = $formFactory;
  }

  public function getFunctions(): array
  {
    return [
      new TwigFunction('renderSubscribeForm', [$this, 'renderSubscribeForm'], [
        'is_safe'           => ['html'],
        'needs_environment' => true,
      ])
    ];
  }

  public function renderSubscribeForm(Environment $environment)
  {
    $formEntity = new Newsletter();
    $form = $this->formFactory->create(NewsletterType::class, $formEntity);

    return $environment->render("_partials/newsletter/subscribe.html.twig", ['form' => $form->createView()]);
  }
}
