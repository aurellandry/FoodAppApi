<?php

declare(strict_types=1);

namespace Domain\Establishment\UseCase\Create;

use Domain\Establishment\Entity\Establishment;

final readonly class EstablishmentCreationResponse
{
    public function __construct(
        public Establishment $establishment
    ) {
    }
}
