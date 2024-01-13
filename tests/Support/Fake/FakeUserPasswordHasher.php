<?php

declare(strict_types=1);

namespace Tests\Support\Fake;

use Domain\User\Entity\User as UserDomain;
use Domain\User\Service\UserPasswordHasher;

final readonly class FakeUserPasswordHasher implements UserPasswordHasher
{
    public function hashPassword(UserDomain $user, string $plainPassword): string
    {
        return base64_encode($plainPassword);;
    }

    public function isPasswordValid(UserDomain $user, string $plainPassword): bool
    {
        return base64_decode((string) $user->getPassword(), true) === $plainPassword;
    }
}
