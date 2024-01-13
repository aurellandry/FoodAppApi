<?php

declare(strict_types=1);

namespace Domain\User\Entity;

use Domain\Shared\ValueObject\Email;
use Domain\Shared\ValueObject\UserIdentifier;
use Domain\User\ValueObject\Role;

final class User
{
    public function __construct(
        private UserIdentifier $uuid,
        private Email $email,
        private Role $role,
        private ?string $firstName,
        private string $lastName,
        private ?string $password = null
    ) {
    }

    public function getIdentifier(): UserIdentifier
    {
        return $this->uuid;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole(Role $role): void
    {
        $this->role = $role;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
