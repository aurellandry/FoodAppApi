<?php

declare(strict_types=1);

namespace Domain\Shared\ValueObject;

abstract readonly class Identifier implements \Stringable
{
    public function __construct(
        private Uuid $uuid
    ) {
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public static function fromUuid(Uuid $uuid): static
    {
        return new static($uuid);
    }

    public static function fromString(string $uuid): static
    {
        return new static(Uuid::fromString($uuid));
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }
}
