<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class UsersGetController extends AbstractController
{
    #[Route('/api/users', name: 'index', methods: ['GET'])]
    public function __invoke(
        UserRepositoryInterface $repository,
    ): JsonResponse {

        if (empty($users = $repository->findAllUsers())) {
            return $this->json([], Response::HTTP_OK);
        }

        return new JsonResponse($users, Response::HTTP_OK);
    }
}
