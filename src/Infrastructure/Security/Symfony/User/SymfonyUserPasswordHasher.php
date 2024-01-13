<?php

declare(strict_types=1);

namespace Infrastructure\Security\Symfony\User;

use Domain\User\Entity\User as UserDomain;
use Domain\User\Service\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class SymfonyUserPasswordHasher implements UserPasswordHasher
{
    public function __construct(
        private UserPasswordHasherInterface $symfonyHasher
    ) {
    }

    public function isPasswordValid(
        UserDomain $user,
        #[\SensitiveParameter] string $plainPassword
    ): bool {
        return $this->symfonyHasher->isPasswordValid(
            new User(
                email: $user->getEmail(),
                realUserIdentifier: $user->getIdentifier(),
                role: $user->getRole(),
                password: $user->getPassword()
            ),
            $plainPassword
        );
    }

    public function hashPassword(
        UserDomain $user,
        #[\SensitiveParameter] string $plainPassword
    ): string {
        return $this->symfonyHasher->hashPassword(
            new User(
                email: $user->getEmail(),
                realUserIdentifier: $user->getIdentifier(),
                role: $user->getRole(),
                password: $user->getPassword()
            ),
            $plainPassword
        );
    }
}
