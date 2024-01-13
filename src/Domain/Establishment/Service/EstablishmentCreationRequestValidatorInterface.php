<?php

declare(strict_types=1);

namespace Domain\Establishment\Service;

use Domain\Establishment\UseCase\Create\EstablishmentCreationRequest;
use Domain\Shared\Error\ErrorList;

interface EstablishmentCreationRequestValidatorInterface
{
    public function validate(EstablishmentCreationRequest $request): bool;

    public function getErrors(): ErrorList;
}
