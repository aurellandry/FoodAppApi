<?php

declare(strict_types=1);

namespace Domain\Establishment\UseCase\Create;

final readonly class EstablishmentCreationRequest
{
    public function __construct(
        public string $type,
        public string $name,
        public ?string $phone,
        public ?string $address,
        public ?string $zipcode,
        public ?string $city,
        public ?string $country,
        public ?string $siret
    ) {
    }
}
