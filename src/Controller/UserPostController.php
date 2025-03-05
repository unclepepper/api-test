<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\UserRequestDto;
use App\Repository\UserRepositoryInterface;
use App\Service\CreateUser\CreateUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class UserPostController extends AbstractController
{
    #[Route('/api/users', name: 'new_user', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] UserRequestDto $dto,
        UserRepositoryInterface $repository,
        CreateUserService $userCreateService,
    ): JsonResponse {

        $email = $dto->getEmail();
        $name  = $dto->getName();

        if (null !== $repository->getUserByEmail($email)) {
            return new JsonResponse(['message' => "User $name already exists"], Response::HTTP_BAD_REQUEST);
        }

        try {

            $userCreateService->create($dto);

        } catch (\Exception $exception) {
            return new JsonResponse(['error' => $exception], Response::HTTP_BAD_REQUEST);
        }


        return new JsonResponse(
            [
                'message' => sprintf('User %s whit email address: %s, was successfully created', $name, $email),
            ],
            Response::HTTP_CREATED
        );
    }
}
