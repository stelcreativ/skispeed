<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testRegisterIsUp()
    {
        $client = static::createClient();

        $client->request('GET', '/register');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}