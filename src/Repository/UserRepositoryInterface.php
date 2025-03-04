<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @return User[]
     */
    public function findAllUsers(): array;

    public function findById(int $id): ?User;

    public function save(User $user): void;

    public function delete(User $user): void;

    public function getUserByEmail(string $email): ?User;
}
