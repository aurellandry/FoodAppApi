<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\Shared\ValueObject\Email;
use Domain\Shared\ValueObject\EstablishmentIdentifier;
use Domain\Establishment\Entity\Establishment as EstablishmentDomain;
use Infrastructure\Persistence\Doctrine\Mapper\EstablishmentMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Infrastructure\Persistence\Doctrine\Entity\Establishment as EstablishmentEntity;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Establishment\Service\EstablishmentPersistenceCommand;
use Domain\Establishment\Service\EstablishmentPersistenceQuery;

/**
 * @method EstablishmentEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method EstablishmentEntity|null findOneBy($id, $lockMode = null, $lockVersion = null)
 */
final class EstablishmentRepository extends ServiceEntityRepository implements EstablishmentPersistenceCommand, EstablishmentPersistenceQuery
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EstablishmentEntity::class);
    }

    public function save(EstablishmentDomain $establishment): void
    {
        $this->getEntityManager()->persist(EstablishmentMapper::domainToEntity($establishment));
    }

    public function findById(EstablishmentIdentifier $establishmentIdentifier): ?EstablishmentDomain
    {
        $establishment = $this->find($establishmentIdentifier);

        if (null === $establishment) {
            return null;
        }

        return EstablishmentMapper::entityToDomain($establishment);
    }

    public function findBySiret(string $siret): ?EstablishmentDomain
    {
        $establishment = $this->findOneBy(['siret' => $siret]);

        if (null === $establishment) {
            return null;
        }

        return EstablishmentMapper::entityToDomain($establishment);
    }
}
