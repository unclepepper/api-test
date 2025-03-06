<?php

namespace App\Tests\api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsersGetControllerTest extends WebTestCase
{
    public const string URL = '/api/users';

    public function testSomething(): void
    {
        $client = static::createClient();


        $client->request('GET', self::URL);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//        self::assertJson($client->getResponse()->getContent());

    }

}
