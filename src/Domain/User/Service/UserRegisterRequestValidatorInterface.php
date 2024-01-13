<?php

declare(strict_types=1);

namespace Domain\User\Service;

use Domain\Shared\Error\ErrorList;
use Domain\User\UseCase\Register\UserRegisterRequest;

interface UserRegisterRequestValidatorInterface
{
    public function validate(UserRegisterRequest $request): bool;

    public function getErrors(): ErrorList;
}
