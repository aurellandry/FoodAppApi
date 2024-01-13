<?php

declare(strict_types=1);

namespace Domain\Establishment\Service;

use Domain\Establishment\Entity\Establishment;

interface EstablishmentPersistenceCommand
{
    public function save(Establishment $establishment): void;
}
