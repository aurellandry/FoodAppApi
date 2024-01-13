<?php

declare(strict_types=1);

namespace Extension\Assert;

use Assert\InvalidArgumentException;
use Assert\LazyAssertionException as BaseLazyAssertionException;

final class LazyAssertionException extends BaseLazyAssertionException
{
    public static function create(string $message, string $propertyPath = null): self
    {
        return new self(
            '',
            [
                new InvalidArgumentException(
                    message: $message,
                    code: 0,
                    propertyPath: $propertyPath
                ),
            ]
        );
    }
}
