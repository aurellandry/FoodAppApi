<?php

declare(strict_types=1);

namespace Domain\User\UseCase\Register;

use Domain\User\Entity\User;

final readonly class UserRegisterResponse
{
    public function __construct(
        public User $user
    ) {
    }
}
