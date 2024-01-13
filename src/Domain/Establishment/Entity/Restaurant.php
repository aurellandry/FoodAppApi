<?php

declare(strict_types=1);

namespace Domain\Establishment\Entity;

use Domain\Establishment\ValueObject\EstablishmentType;

final class Restaurant extends Establishment
{
    public function getType(): EstablishmentType
    {
        return EstablishmentType::Restaurant;
    }
}
