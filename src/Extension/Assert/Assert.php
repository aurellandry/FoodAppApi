<?php

declare(strict_types=1);

namespace Extension\Assert;

use Assert\Assert as BaseAssert;

final class Assert extends BaseAssert
{
    public static function lazy(): LazyAssertion
    {
        $lazyAssertion = new LazyAssertion();

        return $lazyAssertion
            ->setAssertClass(\get_called_class())
            ->setExceptionClass(LazyAssertionException::class)
        ;
    }
}
