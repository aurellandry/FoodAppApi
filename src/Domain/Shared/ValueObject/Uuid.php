<?php

declare(strict_types=1);

namespace Domain\Shared\ValueObject;

final readonly class Uuid implements \Stringable
{
    private function __construct(
        private string $identifier
    ) {
    }

    public static function fromString(string $uuid): self
    {
        return new self($uuid);
    }

    public function __toString(): string
    {
        return $this->identifier;
    }
}
