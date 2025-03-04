<?php

declare(strict_types=1);

namespace App\Service\CreateUser;

use App\Dto\UserRequestDto;
use App\Entity\User;
use App\Repository\UserRepositoryInterface;

readonly class CreateUserService implements CreateUserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function create(UserRequestDto $dto): User
    {
        $user = (new User())
            ->setEmail($dto->getEmail())
            ->setName($dto->getName());

        $this->userRepository->save($user);

        return $user;
    }
}
