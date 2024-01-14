<?php

declare(strict_types=1);

namespace Domain\Establishment\Factory;

use Domain\Establishment\UseCase\Create\EstablishmentCreationRequest;
use Domain\Establishment\Entity\Establishment;
use Domain\Establishment\Entity\Restaurant;
use Domain\Establishment\ValueObject\EstablishmentType;
use Domain\Shared\Service\IdentifierGeneratorInterface;
use Domain\Shared\ValueObject\Address;
use Domain\Shared\ValueObject\EstablishmentIdentifier;
use Domain\Shared\ValueObject\Phone;

final readonly class RestaurantFactory  implements ConcreteEstablishmentFactoryInterface
{
    public function __construct(
        private IdentifierGeneratorInterface $identifierGenerator
    ) {
    }

    public function supports(string $establishmentType): bool
    {
        return $establishmentType === EstablishmentType::Restaurant->value;
    }

    public function createFromRequest(EstablishmentCreationRequest $request): Restaurant
    {
        return new Restaurant(
            EstablishmentIdentifier::fromUuid(
                $this->identifierGenerator->generate()
            ),
            $request->name,
            new Address(
                address: $request->address,
                zipCode: $request->zipcode,
                city: $request->city,
                country: $request->country
            ),
            Phone::fromString($request->phone),
            $request->siret
        );
    }
}
