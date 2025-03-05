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
final class UserDeleteController extends AbstractController
{
    #[Route('/api/users/{id}', name: 'user_item', methods: ['DELETE'])]
    public function __invoke(
        UserRepositoryInterface $repository,
        int $id,
    ): JsonResponse {

        $user = $repository->findById($id);

        if (null === $user) {
            return new JsonResponse(['message' => "User with id: $id, not exist"], Response::HTTP_NOT_FOUND);
        }

        try {
            $repository->delete($user);
        } catch (\Exception $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['message' => "User with id: $id, was deleted"], Response::HTTP_OK, []);
    }
}
