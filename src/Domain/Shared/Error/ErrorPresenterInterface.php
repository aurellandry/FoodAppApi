<?php

declare(strict_types=1);

namespace Domain\Shared\Error;

interface ErrorPresenterInterface
{
    public function presentError(ErrorResponse $response): void;
}
