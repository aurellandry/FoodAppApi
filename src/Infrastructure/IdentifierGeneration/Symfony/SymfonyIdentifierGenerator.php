<?php

declare(strict_types=1);

namespace Infrastructure\IdentifierGeneration\Symfony;

use Domain\Shared\Service\IdentifierGeneratorInterface;
use Domain\Shared\ValueObject\Uuid;
use Symfony\Component\Uid\Factory\UuidFactory;

final readonly class SymfonyIdentifierGenerator implements IdentifierGeneratorInterface
{
    public function __construct(
        private UuidFactory $uuidFactory
    ) {
    }

    public function generate(): Uuid
    {
        return Uuid::fromString((string) $this->uuidFactory->create());
    }
}
