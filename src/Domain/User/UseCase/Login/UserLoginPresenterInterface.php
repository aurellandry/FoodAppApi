<?php

declare(strict_types=1);

namespace Domain\User\UseCase\Login;

use Domain\Shared\Error\ErrorPresenterInterface;

interface UserLoginPresenterInterface extends ErrorPresenterInterface
{
    public function present(UserLoginResponse $response): void;
}
