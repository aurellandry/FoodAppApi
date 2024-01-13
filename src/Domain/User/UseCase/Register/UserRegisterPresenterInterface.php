<?php

declare(strict_types=1);

namespace Domain\User\UseCase\Register;

use Domain\Shared\Error\ErrorPresenterInterface;

interface UserRegisterPresenterInterface extends ErrorPresenterInterface
{
    public function present(UserRegisterResponse $response): void;

    public function displayViewModel(): mixed;
}
