<?php

declare(strict_types=1);

namespace Domain\User\UseCase\Login;

final readonly class UserLoginResponse
{
    public function __construct(
        public string $email
    ) {
    }
}
