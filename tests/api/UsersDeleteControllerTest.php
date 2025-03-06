<?php

namespace App\Tests\api;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsersDeleteControllerTest extends WebTestCase
{
    public const string URL = '/api/users';


    public function testSomething(): void
    {

        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('test@test.com');

        $client->request('DELETE', sprintf('%s/%d', self::URL, $testUser->getId()));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//        self::assertJson($client->getResponse()->getContent());

    }
}
