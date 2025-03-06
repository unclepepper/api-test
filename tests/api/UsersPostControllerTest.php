<?php

namespace App\Tests\api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @group controller
 */
class UsersPostControllerTest extends WebTestCase
{
    public const string URL = '/api/users';

    public function testSomething(): void
    {

        $client = static::createClient();

        $client->request(
            'POST',
            self::URL,
            [
                'name'  => 'Test User Post',
                'email' => 'test-post@test.com',
            ]
        );

        self::assertResponseIsSuccessful();
        self::assertEquals(201, $client->getResponse()->getStatusCode());
        self::assertJson($client->getResponse()->getContent());

    }

    public static function tearDownAfterClass(): void
    {
        /** @var EntityManagerInterface $em */
        $em = self::getContainer()->get(EntityManagerInterface::class);

        $testUsers = $em
            ->getRepository(User::class)
            ->findAll();

        if (!empty($testUsers)) {
            foreach ($testUsers as $testUser) {
                $em->remove($testUser);
            }

            $em->flush();
            $em->clear();
        }
    }
}
