<?php

declare(strict_types=1);

namespace Tests\Support\Fake;

use Domain\Shared\Error\ErrorList;
use Domain\User\Service\UserRegisterRequestValidatorInterface;
use Domain\User\UseCase\Register\UserRegisterRequest;

final class FakeUserRegisterRequestValidator implements UserRegisterRequestValidatorInterface
{
    private bool $isValid = false;

    public function validate(UserRegisterRequest $request): bool
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
