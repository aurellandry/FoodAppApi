<?php

declare(strict_types=1);

namespace Presentation\Shared\Json;

interface JsonViewModelInterface
{
    public function getHttpCode(): int;
}
