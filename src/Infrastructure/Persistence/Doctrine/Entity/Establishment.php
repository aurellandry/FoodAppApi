<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Doctrine\Entity;

use Domain\Shared\ValueObject\Phone;
use Domain\Shared\ValueObject\Uuid;

final class Establishment
{
    public function __construct(
        private Uuid $id,
        private string $name,
        public string $address,
        public ?string $zipCode,
        public string $city,
        public string $country,
        private Phone $phone,
        private string $establishmentType,
        private string $siret
    ) {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
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

    public function getEstablishmentType(): string
    {
        return $this->establishmentType;
    }

    public function setEstablishmentType(string $establishmentType): void
    {
        $this->establishmentType = $establishmentType;
    }
}
