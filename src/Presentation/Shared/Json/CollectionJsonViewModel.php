<?php

declare(strict_types=1);

namespace Presentation\Shared\Json;

final readonly class CollectionJsonViewModel implements JsonViewModelInterface
{
    public function __construct(
        public array $items
    ) {
    }

    public function getHttpCode(): int
    {
        return 200;
    }
}
