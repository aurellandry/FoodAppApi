<?php

declare(strict_types=1);

namespace Domain\Establishment\Service;

use Domain\Establishment\Entity\Establishment as DomainEstablishment;

interface EstablishmentPersistenceQuery
{
    public function findById(string $id): ?DomainEstablishment;

    public function findBySiret(string $siret): ?DomainEstablishment;
}
