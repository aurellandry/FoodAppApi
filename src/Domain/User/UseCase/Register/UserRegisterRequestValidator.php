<?php

declare(strict_types=1);

namespace Domain\User\UseCase\Register;

use Domain\Shared\Error\ErrorList;
use Domain\Shared\ValueObject\Email;
use Domain\User\Service\UserPersistenceQuery;
use Domain\User\Service\UserRegisterRequestValidatorInterface;
use Extension\Assert\Assert;
use Extension\Assert\LazyAssertionException;

final readonly class UserRegisterRequestValidator implements UserRegisterRequestValidatorInterface
{
    private ErrorList $errors;

    public function __construct(
        private UserPersistenceQuery $repository
    ) {
        $this->errors = new ErrorList();
    }

    public function validate(UserRegisterRequest $request): bool
    {
        try {
            Assert::lazy()
                ->that($request->lastName, 'lastName')
                ->notBlank('Please provide a last name')
                ->that($request->password, 'password')
                ->notBlank('Please provide a password')
                ->verifyNow();

            $emailExists = (bool) $this->repository->findByEmail(
                Email::fromString($request->email)
            );
            Assert::lazy()
                ->that($emailExists, 'email')->false('Email already used')
                ->verifyNow();
        } catch (LazyAssertionException $exception) {
            foreach ($exception->getErrorExceptions() as $error) {
                $this->errors->addError(
                    $error->getMessage(),
                    $error->getPropertyPath()
                );
            }

            return false;
        }

        return true;
    }

    public function getErrors(): ErrorList
    {
        return $this->errors;
    }
}
