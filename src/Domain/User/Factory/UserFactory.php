<?php

declare(strict_types=1);

namespace Domain\User\Factory;

use Domain\Shared\Service\IdentifierGeneratorInterface;
use Domain\Shared\ValueObject\Email;
use Domain\Shared\ValueObject\UserIdentifier;
use Domain\User\UseCase\Register\UserRegisterRequest;
use Domain\User\Entity\User;
use Domain\User\Service\UserPasswordHasher;
use Domain\User\ValueObject\Role;

final readonly class UserFactory implements UserFactoryInterface
{
    public function __construct(
        private IdentifierGeneratorInterface $identifierGenerator,
        private UserPasswordHasher $passwordHasher
    ) {
    }

    public function createFromRequest(UserRegisterRequest $request): User
    {
        $userIdentifier = UserIdentifier::fromUuid(
            $this->identifierGenerator->generate()
        );
        $role = match ($request->role) {
            'ROLE_ADMIN' => Role::Admin,
            'ROLE_RESTAURANT_STAFF' => Role::RestaurantStaff,
            'ROLE_RESTAURANT_ADMIN' => Role::RestaurantAdmin,
            default => Role::User,
        };

        $user = new User(
            $userIdentifier,
            Email::fromString($request->email),
            $role,
            $request->firstName,
            $request->lastName
        );

        $password = $this->passwordHasher->hashPassword($user, $request->password);
        $user->setPassword($password);

        return $user;
    }
}
