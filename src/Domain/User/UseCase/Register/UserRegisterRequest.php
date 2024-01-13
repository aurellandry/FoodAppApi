<?php

declare(strict_types=1);

namespace Domain\User\UseCase\Register;

final readonly class UserRegisterRequest
{
    public function __construct(
        public string $email,
        public string $firstName,
        public string $lastName,
        public string $password,
        public ?string $role = null
    ) {
    }
}
