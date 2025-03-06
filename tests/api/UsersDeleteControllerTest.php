<?php

namespace App\Tests\api;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsersDeleteControllerTest extends WebTestCase
{
    public const string URL = '/api/users';

    public function testSomething(): void
    {

        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('test@test.com');

        $client->request('DELETE', sprintf('%s/%d', self::URL, $testUser->getId()));

        self::assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertJson($client->getResponse()->getContent());

    }
}
