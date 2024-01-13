<?php

declare(strict_types=1);

namespace Presentation\Establishment\Create;

use Presentation\Shared\Json\JsonViewModelInterface;

final class EstablishmentCreateJsonViewModel implements JsonViewModelInterface
{
    public int $httpCode = 201;

    public ?EstablishmentCreateViewModel $establishment;

    /**
     * @var ErrorViewModel[]
     */
    public array $errors;

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }
}
