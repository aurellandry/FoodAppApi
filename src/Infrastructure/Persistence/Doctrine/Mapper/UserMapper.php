<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Doctrine\Mapper;

use Domain\Shared\ValueObject\Email;
use Domain\Shared\ValueObject\UserIdentifier;
use Domain\Shared\ValueObject\Uuid;
use Domain\User\ValueObject\Role;
use Extension\Assert\Assertion;
use Infrastructure\Persistence\Doctrine\Entity\User as UserEntity;
use Domain\User\Entity\User as UserDomain;

final class UserMapper
{
    public static function entityToDomain(UserEntity $userEntity): UserDomain
    {
        return new UserDomain(
            uuid: UserIdentifier::fromUuid($userEntity->getId()),
            firstName: $userEntity->getFirstName(),
            lastName: $userEntity->getLastName(),
            email: $userEntity->getEmail(),
            role: Role::from($userEntity->getRole()),
            password: $userEntity->getPassword()
        );
    }

    public static function domainToEntity(UserDomain $userDomain): UserEntity
    {
        $password = $userDomain->getPassword();
        Assertion::notEmpty($password);
        Assertion::notEmpty($userDomain->getEmail());

        return new UserEntity(
            id: $userDomain->getIdentifier()->getUuid(),
            firstName: $userDomain->getFirstName(),
            lastName: $userDomain->getLastName(),
            email: $userDomain->getEmail(),
            role: $userDomain->getRole()->value,
            password: $password
        );
    }
}
