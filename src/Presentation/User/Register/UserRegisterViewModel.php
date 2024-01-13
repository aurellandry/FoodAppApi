<?php

declare(strict_types=1);

namespace Presentation\User\Register;

final class UserRegisterViewModel
{
    public function __construct(
        public string $uuid
    ) {
    }
}
