<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Doctrine\Entity;

use Domain\Shared\ValueObject\Email;
use Domain\Shared\ValueObject\Uuid;

final class User
{
    public function __construct(
        private Uuid $id,
        private ?string $firstName,
        private string $lastName,
        private Email $email,
        private string $role,
        private string $password
    ) {
    }

    public function getId(): Uuid
    {
        return $this->id;
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

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
