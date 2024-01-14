<?php

declare(strict_types=1);

namespace Infrastructure\Security\Symfony\User;

use Domain\Shared\ValueObject\Email;
use Domain\Shared\ValueObject\UserIdentifier;
use Domain\User\ValueObject\Role;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(
        private Email $email,
        private UserIdentifier $realUserIdentifier,
        private Role $role,
        private ?string $password = null
    ) {
    }

    public function getRoles(): array
    {
        return match ($this->role) {
            Role::Admin => ['ROLE_ADMIN', 'ROLE_USER'],
            Role::User => ['ROLE_USER']
        };
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->getEmail();
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getRealUserIdentifier(): UserIdentifier
    {
        return $this->realUserIdentifier;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }
}
