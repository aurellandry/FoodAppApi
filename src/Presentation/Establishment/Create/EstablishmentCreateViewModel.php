<?php

declare(strict_types=1);

namespace Presentation\Establishment\Create;

final class EstablishmentCreateViewModel
{
    public function __construct(
        public string $uuid
    ) {
    }
}
