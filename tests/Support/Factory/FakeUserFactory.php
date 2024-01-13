<?php

declare(strict_types=1);

namespace Tests\Support\Factory;

use Domain\Shared\ValueObject\Email;
use Domain\Shared\ValueObject\UserIdentifier;
use Domain\User\Entity\User;
use Domain\User\Factory\UserFactoryInterface;
use Domain\User\UseCase\Register\UserRegisterRequest;
use Domain\User\ValueObject\Role;
use Tests\Support\Fake\FakeUserPasswordHasher;

final readonly class FakeUserFactory implements UserFactoryInterface
{
    public static function create(
        string $id,
        string $email,
        string $firstName,
        string $lastName,
        string $plainPassword,
        Role $role = Role::User
    ): User {
        $user = new User(
            UserIdentifier::fromString($id),
            Email::fromString($email),
            $role,
            $firstName,
            $lastName
        );

        $hashedPassword = (new FakeUserPasswordHasher())->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        return $user;
    }

    public function createFromRequest(UserRegisterRequest $request): User
    {
        $user = new User(
            UserIdentifier::fromString('1558fa4d-2c64-42e8-9269-5ecb52dcba78'),
            Email::fromString($request->email),
            Role::User,
            $request->firstName,
            $request->lastName
        );

        $hashedPassword = (new FakeUserPasswordHasher())->hashPassword(
            $user,
            $request->password
        );
        $user->setPassword($hashedPassword);

        return $user;
    }
}
