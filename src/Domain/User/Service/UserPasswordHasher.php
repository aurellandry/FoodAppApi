<?php

declare(strict_types=1);

namespace Domain\User\Service;

use Domain\User\Entity\User;

interface UserPasswordHasher
{
    public function hashPassword(
        User $user,
        #[\SensitiveParameter] string $plainPassword
    ): string;

    public function isPasswordValid(
        User $user,
        #[\SensitiveParameter] string $plainPassword
    ): bool;
}
