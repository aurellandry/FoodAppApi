<?php

declare(strict_types=1);

namespace Domain\Establishment\Service;

use Domain\Establishment\Entity\Establishment as EstablishmentDomain;
use Domain\Shared\ValueObject\EstablishmentIdentifier;

interface EstablishmentPersistenceQuery
{
    public function findById(EstablishmentIdentifier $id): ?EstablishmentDomain;

    public function findBySiret(string $siret): ?EstablishmentDomain;
}
