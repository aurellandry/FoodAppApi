<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Doctrine\Type;

use Domain\Shared\ValueObject\Identifier;
use Domain\Shared\ValueObject\Uuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class UuidType extends Type
{
    public const NAME = 'uuid';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return "UUID NOT NULL";
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Uuid
    {
        /** @var string|null $value */
        if (null === $value) {
            return null;
        }

        try {
            return Uuid::fromString($value);
        } catch (\InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, self::lookupName($this), $e);
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        /** @var Identifier|Uuid|null $value */
        if (null === $value) {
            return null;
        }

        return (string) $value;
    }
}
