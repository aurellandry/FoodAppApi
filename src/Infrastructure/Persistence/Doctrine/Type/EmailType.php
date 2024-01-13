<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Doctrine\Type;

use Domain\Shared\ValueObject\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class EmailType extends Type
{
    public const NAME = 'email';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'VARCHAR(255)';
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email
    {
        /** @var string|null $value */
        if (null === $value) {
            return null;
        }

        try {
            return Email::fromString($value);
        } catch (\InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, self::lookupName($this), $e);
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        /** @var Email|null $value */
        if (null === $value) {
            return null;
        }

        if ($value instanceof Email) {
            return parent::convertToDatabaseValue((string) $value, $platform);
        }

        throw ConversionException::conversionFailedInvalidType($value, self::lookupName($this), ['null', Email::class]);
    }
}
