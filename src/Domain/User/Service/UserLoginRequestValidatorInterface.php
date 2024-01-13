<?php

declare(strict_types=1);

namespace Domain\User\Service;

use Domain\Shared\Error\ErrorList;
use Domain\User\UseCase\Login\UserLoginRequest;

interface UserLoginRequestValidatorInterface
{
    public function validate(UserLoginRequest $request): bool;

    public function getErrors(): ErrorList;
}
