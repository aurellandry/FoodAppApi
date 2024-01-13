<?php

declare(strict_types=1);

namespace Domain\Establishment\Factory;

use Domain\Establishment\Entity\Establishment;
use Domain\Establishment\UseCase\Create\EstablishmentCreationRequest;

interface ConcreteEstablishmentFactoryInterface
{
    public function supports(string $establishmentType): bool;

    public function createFromRequest(EstablishmentCreationRequest $request): Establishment;
}
