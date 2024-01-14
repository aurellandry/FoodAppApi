<?php

declare(strict_types=1);

namespace Domain\Establishment\Entity;

use Domain\Establishment\ValueObject\EstablishmentType;
use Domain\Shared\ValueObject\Address;
use Domain\Shared\ValueObject\EstablishmentIdentifier;
use Domain\Shared\ValueObject\Phone;

abstract class Establishment
{
    public function __construct(
        private EstablishmentIdentifier $uuid,
        private string $name,
        private Address $address,
        private Phone $phone,
        private string $siret
    ) {
    }

    public function getId(): EstablishmentIdentifier
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function setPhone(Phone $phone): void
    {
        $this->phone = $phone;
    }

    public function getSiret(): string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): void
    {
        $this->siret = $siret;
    }

    abstract public function getType(): EstablishmentType;
}
