<?php

declare(strict_types=1);

namespace Tests\Support\Factory;

use Domain\Establishment\Entity\Establishment;
use Domain\Establishment\Entity\Restaurant;
use Domain\Establishment\Factory\EstablishmentFactoryInterface;
use Domain\Establishment\UseCase\Create\EstablishmentCreationRequest;
use Domain\Establishment\ValueObject\EstablishmentType;
use Domain\Shared\ValueObject\Address;
use Domain\Shared\ValueObject\EstablishmentIdentifier;
use Domain\Shared\ValueObject\Phone;
use InvalidArgumentException;

final readonly class FakeEstablishmentFactory implements EstablishmentFactoryInterface
{
    public static function create(
        string $id,
        string $type,
        string $name,
        string $siret,
        ?string $phone,
        ?string $address,
        ?string $zipcode,
        ?string $city,
        ?string $country,
    ): Establishment {
        return match ($type) {
            (EstablishmentType::Restaurant)->value => new Restaurant(
                uuid: EstablishmentIdentifier::fromString($id),
                name: $name,
                address: new Address(
                    address: $address,
                    zipCode: $zipcode,
                    city: $city,
                    country: $country
                ),
                phone: Phone::fromString($phone),
                siret: $siret
            ),
            default => throw new InvalidArgumentException(
                sprintf('Unsupported establishment type "%s"', $type)
            )
        };
    }

    public function createFromRequest(
        EstablishmentCreationRequest $request
    ): Establishment {
        return match ($request->type) {
            (EstablishmentType::Restaurant)->value => new Restaurant(
                uuid: EstablishmentIdentifier::fromString(
                    'c6da0062-0e8f-4e99-bcbc-22b1431535c9'
                ),
                name: $request->name,
                address: new Address(
                    address: $request->address,
                    zipCode: $request->zipcode,
                    city: $request->city,
                    country: $request->country
                ),
                phone: Phone::fromString($request->phone),
                siret: $request->siret
            ),
            default => throw new InvalidArgumentException(
                sprintf('Unsupported establishment type "%s"', $request->type)
            )
        };
    }
}
