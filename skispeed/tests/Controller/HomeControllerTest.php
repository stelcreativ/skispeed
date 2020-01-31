<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{

    public function testIndexLoad()
    {
        $this->client = static::createClient();

        $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

    }
}
