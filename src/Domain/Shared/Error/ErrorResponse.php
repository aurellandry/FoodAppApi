<?php

declare(strict_types=1);

namespace Domain\Shared\Error;

final class ErrorResponse
{
    public function __construct(
        public ErrorList $errorList
    ) {
    }
}
