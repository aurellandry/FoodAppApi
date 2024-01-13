<?php

declare(strict_types=1);

namespace Tests\Support\Fake;

use Domain\Shared\Error\ErrorList;
use Domain\User\UseCase\Login\UserLoginRequest;
use Domain\User\Service\UserLoginRequestValidatorInterface;

final class FakeUserLoginRequestValidator implements UserLoginRequestValidatorInterface
{
    private bool $isValid = false;

    public function validate(UserLoginRequest $request): bool
    {
        return $this->isValid;
    }

    public function getErrors(): ErrorList
    {
        return new ErrorList();
    }

    public function shouldBeInvalid(): self
    {
        $this->isValid = false;

        return $this;
    }

    public function shouldBeValid(): self
    {
        $this->isValid = true;

        return $this;
    }
}
