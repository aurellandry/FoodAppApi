<?php

declare(strict_types=1);

namespace Tests\Support\Repository;

use Domain\Establishment\Entity\Establishment;
use Domain\Establishment\Service\EstablishmentPersistenceCommand;
use Domain\Establishment\Service\EstablishmentPersistenceQuery;
use Tests\Support\Factory\FakeEstablishmentFactory;

final class FakeEstablishmentRepository implements EstablishmentPersistenceCommand, EstablishmentPersistenceQuery
{
    private array $establishments;

    public function __construct()
    {
        $this->establishments = [
            FakeEstablishmentFactory::create(
                'e012d897-fb12-4780-9177-93c6f9fec8a5',
                'RESTAURANT',
                'My Test Restaurant',
                '+33601020304',
                '23 rue Cherki',
                '75002',
                'Paris',
                'France',
                '55327987900324'
            )
        ];
    }

    public function save(Establishment $establishment): void
    {
        $this->establishments[] = $establishment;
    }

    public function findById(string $id): ?Establishment
    {
        $establishments = array_filter(
            $this->establishments,
            function (Establishment $establishment) use ($id) {
                return $establishment->getId() === $id;
            }
        );

        return count($establishments) > 0 ? current($establishments) : null;
    }

    public function findBySiret(string $siret): ?Establishment
    {
        $establishments = array_filter(
            $this->establishments,
            function (Establishment $establishment) use ($siret) {
                return $establishment->getSiret() === $siret;
            }
        );

        return count($establishments) > 0 ? current($establishments) : null;
    }
}
