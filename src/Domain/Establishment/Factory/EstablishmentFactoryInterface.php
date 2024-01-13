<?php

declare(strict_types=1);

namespace Domain\Establishment\Factory;

use Domain\Establishment\Entity\Establishment;
use Domain\Establishment\UseCase\Create\EstablishmentCreationRequest;

interface EstablishmentFactoryInterface
{
    public function createFromRequest(EstablishmentCreationRequest $request): Establishment;
}
