<?php

declare(strict_types=1);

namespace Presentation\Shared\Json;

final class ErrorJsonViewModel implements JsonViewModelInterface
{
    public int $httpCode = 422;

    /**
     * @var ErrorViewModel[]
     */
    public array $errors;

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }
}
