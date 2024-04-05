<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
  public function send($to_email, $to_name, $subject, $template, $vars = null)
  {

    //recover the template
    $content = file_get_contents(dirname(__DIR__) . '/Mail/' . $template);

    // recover $vars to put the name of user on welcome.html
    if ($vars) {
      foreach ($vars as $key => $var) {
        $content = str_replace('{' . $key . '}', $var, $content);
      }
    }


    $mj = new Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);

    $body = [
      'Messages' => [
        [
          'From' => [
            'Email' => "meneghettimarcos@outlook.com",
            'Name' => "Tasty Drink Bar & Shop"
          ],
          'To' => [
            [
              'Email' => $to_email,
              'Name' => $to_name
            ]
          ],
          'TemplateID' => 5851002,
          'TemplateLanguage' => true,
          'Subject' => $subject,
          'Variables' => [
            'content' => $content
          ]
        ]
      ]
    ];

    $mj->post(Resources::$Email, ['body' => $body]);
  }
}
