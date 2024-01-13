<?php

declare(strict_types=1);

namespace Domain\Establishment\UseCase\Create;

use Domain\Shared\Error\ErrorPresenterInterface;

interface EstablishmentCreationPresenterInterface extends ErrorPresenterInterface
{
    public function present(EstablishmentCreationResponse $response): void;

    public function displayViewModel(): mixed;
}
