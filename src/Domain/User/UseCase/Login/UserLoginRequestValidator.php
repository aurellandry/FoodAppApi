<?php

declare(strict_types=1);

namespace Domain\User\UseCase\Login;

use Domain\Shared\Error\ErrorList;
use Domain\Shared\ValueObject\Email;
use Domain\User\Service\UserLoginRequestValidatorInterface;
use Domain\User\Service\UserPasswordHasher;
use Domain\User\Service\UserPersistenceQuery;
use Extension\Assert\Assert;
use Extension\Assert\LazyAssertionException;

final readonly class UserLoginRequestValidator implements UserLoginRequestValidatorInterface
{
    private ErrorList $errors;

    public function __construct(
        private UserPersistenceQuery $persistence,
        private UserPasswordHasher $userPasswordHasher
    ) {
        $this->errors = new ErrorList();
    }

    public function validate(UserLoginRequest $request): bool
    {
        try {
            Assert::lazy()
                ->that($request->email, 'email')
                ->email('Please provide a valid email')
                ->verifyNow();

            $user = $this->persistence->findByEmail(Email::fromString($request->email));
            if (is_null($user) || !$this->userPasswordHasher->isPasswordValid($user, $request->password)) {
                throw LazyAssertionException::create('Invalid credentials.', 'login');
            }

            return true;
        } catch (LazyAssertionException $exception) {
            foreach ($exception->getErrorExceptions() as $error) {
                $this->errors->addError(
                    $error->getMessage(),
                    $error->getPropertyPath()
                );
            }

            return false;
        }
    }

    public function getErrors(): ErrorList
    {
        return $this->errors;
    }
}
