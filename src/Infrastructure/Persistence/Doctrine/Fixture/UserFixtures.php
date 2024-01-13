<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Doctrine\Fixture;

use Domain\Shared\ValueObject\Email;
use Domain\Shared\ValueObject\UserIdentifier;
use Domain\User\ValueObject\Role;
use Domain\User\Entity\User;
use Domain\User\Service\UserPasswordHasher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Domain\User\Service\UserPersistenceCommand;

final class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasher $passwordHasher,
        private readonly UserPersistenceCommand $persistence
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User(
            uuid: UserIdentifier::fromString('6f4c350e-8376-4311-a839-1de1a5ebd29b'),
            firstName: 'Bruce',
            lastName: 'Wayne',
            email: Email::fromString('bruce.wayne@mail.com'),
            role: Role::User,
        );

        $password = $this->passwordHasher->hashPassword($user, 'password');
        $user->setPassword($password);

        $this->persistence->save($user);
        $manager->flush();
    }
}
