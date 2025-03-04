<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UserRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 20)]
        private string $name,
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 20)]
        #[Assert\Email]
        private string $email,
    ) {
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
