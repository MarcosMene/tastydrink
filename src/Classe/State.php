<?php

namespace App\Classe;

class State
{

  public const STATE = [
    '3' => [
      'label' => 'On preparation',
      'email_subject' => 'Order in preparation',
      'email_template' => 'order_state_3.html'
    ],
    '4' => [
      'label' => 'Dispatched',
      'email_subject' => 'Order shipped',
      'email_template' => 'order_state_4.html'
    ],
    '5' => [
      'label' => 'Cancel',
      'email_subject' => 'Order cancelled',
      'email_template' => 'order_state_5.html'
    ],
  ];
}
