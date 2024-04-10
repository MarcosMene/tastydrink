<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testSomething(): void
    {
        // 1.
        $client = static::createClient();
        $client->request('GET', '/sign-up');

        // 2. (firstname, lastname, email, password, confirmation du password)
        $client->submitForm('Create', [
            'sign_up[firstname]' => 'John',
            'sign_up[lastname]' => 'Doe',
            'sign_up[email]' => 'test@gmail.com',
            'sign_up[password][first]' => '123456789',
            'sign_up[password][second]' => '123456789'
        ]);

        //follow
        $this->assertResponseRedirects('/login');
        $client->followRedirect();

        //check if this message appears 'Your account was  created successfully! You can now log in.' only if form is validated
        $this->assertSelectorExists('div:contains("Your account was  created successfully! You can now log in.")');
    }
}