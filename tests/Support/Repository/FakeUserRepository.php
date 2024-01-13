<?php

declare(strict_types=1);

namespace Tests\Support\Repository;

use Domain\Shared\ValueObject\Email;
use Domain\Shared\ValueObject\UserIdentifier;
use Domain\User\Entity\User as UserDomain;
use Domain\User\Service\UserPersistenceCommand;
use Domain\User\Service\UserPersistenceQuery;
use Tests\Support\Factory\FakeUserFactory;

final class FakeUserRepository implements UserPersistenceCommand, UserPersistenceQuery
{
    private array $users;

    public function __construct()
    {
        $this->users = [
            FakeUserFactory::create(
                'e012d897-fb12-4780-9177-93c6f9fec8a5',
                'dummy.user@test.com',
                'Dummy',
                'User',
                'password'
            )
        ];
    }

    public function save(UserDomain $user): void
    {
        $this->users[] = $user;
    }

    public function findByIdentifier(UserIdentifier $id): ?UserDomain
    {
        $users = array_filter($this->users, function (UserDomain $user) use ($id) {
            return $user->getIdentifier() === (string) $id;
        });

        return count($users) > 0 ? current($users) : null;
    }

    public function findByEmail(Email $email): ?UserDomain
    {
        $users = array_filter($this->users, function (UserDomain $user) use ($email) {
            return (string) $user->getEmail() === (string) $email;
        });

        return count($users) > 0 ? current($users) : null;
    }
}
