<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\Shared\ValueObject\Email;
use Domain\Shared\ValueObject\UserIdentifier;
use Domain\User\Entity\User as UserDomain;
use Infrastructure\Persistence\Doctrine\Mapper\UserMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Infrastructure\Persistence\Doctrine\Entity\User as UserEntity;
use Doctrine\Persistence\ManagerRegistry;
use Domain\User\Service\UserPersistenceCommand;
use Domain\User\Service\UserPersistenceQuery;

/**
 * @method UserEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEntity|null findOneBy($id, $lockMode = null, $lockVersion = null)
 */
final class UserRepository extends ServiceEntityRepository implements UserPersistenceCommand, UserPersistenceQuery
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntity::class);
    }

    public function save(UserDomain $user): void
    {
        $this->getEntityManager()->persist(UserMapper::domainToEntity($user));
    }

    public function findByIdentifier(UserIdentifier $userIdentifier): ?UserDomain
    {
        $user = $this->find($userIdentifier);

        if (null === $user) {
            return null;
        }

        return UserMapper::entityToDomain($user);
    }

    public function mailExists(Email $email): bool
    {
        return 0 !== $this->count(['email' => $email]);
    }

    public function findByEmail(Email $email): ?UserDomain
    {
        $user = $this->findOneBy(['email' => $email]);

        if (null === $user) {
            return null;
        }

        return UserMapper::entityToDomain($user);
    }
}
