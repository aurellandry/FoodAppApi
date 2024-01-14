<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Doctrine\Mapper;

use Domain\Shared\ValueObject\EstablishmentIdentifier;
use Extension\Assert\Assertion;
use Infrastructure\Persistence\Doctrine\Entity\Establishment as EstablishmentEntity;
use Domain\Establishment\Entity\Establishment as EstablishmentDomain;
use Domain\Establishment\Entity\Restaurant as RestaurantDomain;
use Domain\Establishment\ValueObject\EstablishmentType;
use Domain\Shared\ValueObject\Address;
use InvalidArgumentException;

final class EstablishmentMapper
{
    /**
     * @throws InvalidArgumentException
     */
    public static function entityToDomain(EstablishmentEntity $establishmentEntity): EstablishmentDomain
    {
        $type = $establishmentEntity->getEstablishmentType();

        return match ($type) {
            EstablishmentType::Restaurant->value => new RestaurantDomain(
                uuid: EstablishmentIdentifier::fromUuid($establishmentEntity->getId()),
                name: $establishmentEntity->getName(),
                address: new Address(
                    address: $establishmentEntity->getAddress(),
                    zipCode: $establishmentEntity->getZipCode(),
                    city: $establishmentEntity->getCity(),
                    country: $establishmentEntity->getCountry()
                ),
                phone: $establishmentEntity->getPhone(),
                siret: $establishmentEntity->getSiret()
            ),
            default => throw new InvalidArgumentException(
                sprintf('Unknown establishment type "%s"', $type)
            ),
        };
    }

    public static function domainToEntity(EstablishmentDomain $establishmentDomain): EstablishmentEntity
    {
        $name = $establishmentDomain->getName();
        Assertion::notEmpty($name);

        return new EstablishmentEntity(
            id: $establishmentDomain->getId()->getUuid(),
            name: $name,
            address: $establishmentDomain->getAddress()->address,
            zipCode: $establishmentDomain->getAddress()->zipCode,
            city: $establishmentDomain->getAddress()->city,
            country: $establishmentDomain->getAddress()->country,
            phone: $establishmentDomain->getPhone(),
            establishmentType: $establishmentDomain->getType()->value,
            siret: $establishmentDomain->getSiret()
        );
    }
}
