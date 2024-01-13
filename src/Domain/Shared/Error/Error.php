<?php

declare(strict_types=1);

namespace Domain\Shared\Error;

final readonly class Error
{
    public function __construct(
        public ?string $fieldName,
        public string $message
    ) {
    }
}
