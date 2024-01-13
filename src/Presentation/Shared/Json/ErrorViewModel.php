<?php

declare(strict_types=1);

namespace Presentation\Shared\Json;

final readonly class ErrorViewModel
{
    public function __construct(
        public ?string $fieldName,
        public string $error
    ) {
    }
}
