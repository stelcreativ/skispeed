<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
    public function testIndexLoad()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        echo $client->getResponse()->getContent();
    }
}
