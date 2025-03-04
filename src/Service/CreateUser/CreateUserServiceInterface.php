<?php

namespace App\Service\CreateUser;

use App\Dto\UserRequestDto;
use App\Entity\User;

interface CreateUserServiceInterface
{
    public function create(UserRequestDto $dto): User;
}
