<?php

declare(strict_types=1);

namespace Domain\Shared\Service;

use Domain\Shared\ValueObject\Uuid;

interface IdentifierGeneratorInterface
{
    public function generate(): Uuid;
}
