<?php

declare(strict_types=1);

namespace Domain\Shared\ValueObject;

final readonly class Address implements \Stringable
{
    public function __construct(
        public string $address,
        public string $city,
        public string $country,
        public ?string $zipCode = null,
    ) {
    }

    public function __toString(): string
    {
        return sprintf(
            '%s, %s %s, %s.',
            $this->address,
            $this->zipCode ?? '',
            $this->city,
            $this->country
        );
    }
}
