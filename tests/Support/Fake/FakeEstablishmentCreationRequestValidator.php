<?php

declare(strict_types=1);

namespace Tests\Support\Fake;

use Domain\Establishment\UseCase\Create\EstablishmentCreationRequest;
use Domain\Establishment\Service\EstablishmentCreationRequestValidatorInterface;
use Domain\Shared\Error\ErrorList;

final class FakeEstablishmentCreationRequestValidator implements EstablishmentCreationRequestValidatorInterface
{
    private bool $isValid = false;

    public function validate(EstablishmentCreationRequest $request): bool
    {
        return $this->isValid;
    }

    public function getErrors(): ErrorList
    {
        return new ErrorList();
    }

    public function shouldBeInvalid(): self
    {
        $this->isValid = false;

        return $this;
    }

    public function shouldBeValid(): self
    {
        $this->isValid = true;

        return $this;
    }
}
