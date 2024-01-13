<?php

declare(strict_types=1);

namespace Domain\User\Factory;

use Domain\User\Entity\User;
use Domain\User\UseCase\Register\UserRegisterRequest;

interface UserFactoryInterface
{
    public function createFromRequest(UserRegisterRequest $request): User;
}
