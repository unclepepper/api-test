<?php

namespace App\Tests\api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


/**
 * @group controller
 */
class UsersGetControllerTest extends WebTestCase
{
    public const string URL = '/api/users';

    public function testGetItems(): void
    {
        $client = static::createClient();


        $client->request('GET', self::URL);

        self::assertResponseIsSuccessful();
        self::assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertJson($client->getResponse()->getContent());

    }

}
