<?php

declare(strict_types=1);

namespace Domain\Shared\ValueObject;

use Extension\Assert\Assertion;

final readonly class Phone implements \Stringable
{
    private function __construct(
        private string $phoneNumber
    ) {
    }

    public static function fromString(string $phoneNumber): self
    {
        Assertion::e164($phoneNumber);

        return new static($phoneNumber);
    }

    public function __toString(): string
    {
        return $this->phoneNumber;
    }
}
