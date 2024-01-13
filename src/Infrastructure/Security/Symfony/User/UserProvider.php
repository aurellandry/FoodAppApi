<?php

declare(strict_types=1);

namespace Infrastructure\Security\Symfony\User;

use Domain\Shared\ValueObject\Email;
use Domain\User\Service\UserPersistenceQuery;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final readonly class UserProvider implements UserProviderInterface
{
    public function __construct(
        private UserPersistenceQuery $userRepository
    ) {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                \sprintf('Instance of "%s" is not supported.', $user::class)
            );
        }

        $userDomain = $this->userRepository->findByIdentifier(
            $user->getRealUserIdentifier()
        );

        if (null === $userDomain) {
            throw new UserNotFoundException();
        }

        return new User(
            email: $userDomain->getEmail(),
            realUserIdentifier: $userDomain->getIdentifier(),
            role: $userDomain->getRole(),
        );
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $userDomain = $this->userRepository->findByEmail(Email::fromString($identifier));

        if (null === $userDomain) {
            throw new UserNotFoundException();
        }

        return new User(
            email: $userDomain->getEmail(),
            realUserIdentifier: $userDomain->getIdentifier(),
            role: $userDomain->getRole(),
        );
    }
}
