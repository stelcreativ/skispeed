<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;

class SecurityControllerTest{
    public function testRegisterIsUp()
    {
        $client = static::createClient();

        $client->request('GET', '/register');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}