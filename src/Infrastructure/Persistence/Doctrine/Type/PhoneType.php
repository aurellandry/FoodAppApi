<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Doctrine\Type;

use Domain\Shared\ValueObject\Phone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class PhoneType extends Type
{
    public const NAME = 'phone';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'VARCHAR(255)';
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Phone
    {
        /** @var string|null $value */
        if (null === $value) {
            return null;
        }

        try {
            return Phone::fromString($value);
        } catch (\InvalidArgumentException $exception) {
            throw ConversionException::conversionFailed(
                $value,
                self::lookupName($this),
                $exception
            );
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        /** @var Phone|null $value */
        if (null === $value) {
            return null;
        }

        if ($value instanceof Phone) {
            return parent::convertToDatabaseValue((string) $value, $platform);
        }

        throw ConversionException::conversionFailedInvalidType(
            $value,
            self::lookupName($this),
            ['null', Phone::class]
        );
    }
}
