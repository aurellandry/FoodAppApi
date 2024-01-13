<?php

declare(strict_types=1);

namespace Domain\User\UseCase\Login;

use Domain\Shared\Error\ErrorResponse;
use Domain\Shared\ValueObject\Email;
use Domain\User\Service\UserLoginRequestValidatorInterface;
use Domain\User\Service\UserPersistenceQuery;

final readonly class UserLogin
{
    public function __construct(
        private UserPersistenceQuery $repository,
        private UserLoginRequestValidatorInterface $validator,
    ) {
    }

    public function execute(
        UserLoginRequest $request,
        UserLoginPresenterInterface $presenter
    ): void {
        if (!$this->validator->validate($request)) {
            $presenter->presentError(
                new ErrorResponse(
                    $this->validator->getErrors()
                )
            );

            return;
        }

        $foundUser = $this->repository->findByEmail(Email::fromString($request->email));

        $presenter->present(
            new UserLoginResponse((string) $foundUser->getEmail())
        );
    }
}
