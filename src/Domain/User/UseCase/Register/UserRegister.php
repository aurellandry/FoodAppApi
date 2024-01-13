<?php

declare(strict_types=1);

namespace Domain\User\UseCase\Register;

use Domain\Shared\Error\ErrorResponse;
use Domain\User\Factory\UserFactoryInterface;
use Domain\User\Service\UserPersistenceCommand;
use Domain\User\Service\UserRegisterRequestValidatorInterface;

final readonly class UserRegister
{
    public function __construct(
        private UserFactoryInterface $userFactory,
        private UserPersistenceCommand $persistence,
        private UserRegisterRequestValidatorInterface $validator
    ) {
    }

    public function execute(UserRegisterRequest $request, UserRegisterPresenterInterface $presenter): void
    {
        if (!$this->validator->validate($request)) {
            $presenter->presentError(
                new ErrorResponse(
                    $this->validator->getErrors()
                )
            );

            return;
        }

        $user = $this->userFactory->createFromRequest($request);

        $this->persistence->save($user);

        $presenter->present(new UserRegisterResponse($user));
    }
}
