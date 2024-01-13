<?php

declare(strict_types=1);

namespace Domain\Shared\ValueObject;

use Extension\Assert\Assertion;

final readonly class Email implements \Stringable
{
    private function __construct(
        private string $email
    ) {
    }

    public static function fromString(string $email): self
    {
        Assertion::email($email);

        return new self($email);
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
