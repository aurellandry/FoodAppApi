<?php

declare(strict_types=1);

namespace Tests\Support\Generator;

use Domain\Shared\Service\IdentifierGeneratorInterface;
use Domain\Shared\ValueObject\Uuid;

final readonly class FakeIdentifierGenerator implements IdentifierGeneratorInterface
{
    public function generate(): Uuid
    {
        return Uuid::fromString('7aff0c21-f4f3-499e-a370-c0cda01450ea');
    }
}
