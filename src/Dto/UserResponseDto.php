<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UserResponseDto
{
    public function __construct(
        private int $id,
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 20)]
        private string $name,
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 20)]
        #[Assert\Email]
        private string $email,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
