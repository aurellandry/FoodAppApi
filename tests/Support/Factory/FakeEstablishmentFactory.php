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
        ?string $phone,
        ?string $address,
        ?string $zipcode,
        ?string $city,
        ?string $country,
        ?string $siret
    ): Establishment {
        return match ($type) {
            (EstablishmentType::Restaurant)->value => new Restaurant(
                EstablishmentIdentifier::fromString(
                    'c6da0062-0e8f-4e99-bcbc-22b1431535c9'
                ),
                $name,
                new Address(
                    $address,
                    $zipcode,
                    $city,
                    $country
                ),
                Phone::fromString($phone),
                $siret
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
                EstablishmentIdentifier::fromString(
                    'c6da0062-0e8f-4e99-bcbc-22b1431535c9'
                ),
                $request->name,
                new Address(
                    $request->address,
                    $request->zipcode,
                    $request->city,
                    $request->country
                ),
                Phone::fromString($request->phone),
                $request->siret
            ),
            default => throw new InvalidArgumentException(
                sprintf('Unsupported establishment type "%s"', $request->type)
            )
        };
    }
}
