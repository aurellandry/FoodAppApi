<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Shared\ValueObject\Email;
use Domain\Shared\ValueObject\UserIdentifier;
use Domain\User\Entity\User as UserDomain;
use Domain\User\ValueObject\Role;
use Infrastructure\Persistence\Doctrine\Entity\User;
use Infrastructure\Persistence\Doctrine\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    private UserRepository $sut;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = self::getContainer()->get('doctrine.orm.default_entity_manager');
        $this->sut = $this->entityManager->getRepository(User::class);
    }

    public function testSave(): void
    {
        // Given
        $user = new UserDomain(
            uuid: UserIdentifier::fromString('13647015-b708-4296-bae5-263a1b221d98'),
            email: Email::fromString('tom.cruise@test.com'),
            role: Role::User,
            firstName: 'Tom',
            lastName: 'Cruise',
            password: 'encodedPassword'
        );

        // When
        $this->sut->save($user);
        $this->entityManager->flush();

        // Then
        $persistedUser = self::getContainer()->get('doctrine.dbal.default_connection')
            ->fetchAssociative(
                <<<'SQL'
                    SELECT * FROM users WHERE email = 'tom.cruise@test.com'
                SQL
            );

        self::assertEquals('13647015-b708-4296-bae5-263a1b221d98', $persistedUser['id']);
        self::assertEquals('Tom', $persistedUser['first_name']);
        self::assertEquals('Cruise', $persistedUser['last_name']);
        self::assertEquals('tom.cruise@test.com', $persistedUser['email']);
        self::assertEquals(Role::User->value, $persistedUser['role']);
        self::assertEquals('encodedPassword', $persistedUser['password']);
    }

    public function testFindByIdentifier(): void
    {
        // Given
        self::getContainer()->get('doctrine.dbal.default_connection')
            ->insert(
                'users',
                [
                    'id' => '13647015-b708-4296-bae5-263a1b221d98',
                    'first_name' => 'Tom',
                    'last_name' => 'Cruise',
                    'email' => 'tom.cruise@test.com',
                    'role' => Role::User->value,
                    'password' => 'encodedPassword',
                ]
            );

        // When
        $id = UserIdentifier::fromString('13647015-b708-4296-bae5-263a1b221d98');
        $actualUser = $this->sut->findByIdentifier($id);

        // Then
        self::assertEquals($id, $actualUser->getIdentifier());
    }

    public function testEmailExistsShouldSucceed(): void
    {
        // Given
        self::getContainer()->get('doctrine.dbal.default_connection')
            ->insert(
                'users',
                [
                    'id' => '13647015-b708-4296-bae5-263a1b221d98',
                    'first_name' => 'Tom',
                    'last_name' => 'Cruise',
                    'email' => 'tom.cruise@test.com',
                    'role' => Role::User->value,
                    'password' => 'encodedPassword',
                ]
            );

        // When
        $email = Email::fromString('tom.cruise@test.com');
        $mailExists = $this->sut->mailExists($email);

        // Then
        self::assertTrue($mailExists);
    }

    public function testEmailExistsShouldFail(): void
    {
        // Given
        $email = Email::fromString('johnny.depp@test.com');

        // When
        $mailExists = $this->sut->mailExists($email);

        // Then
        self::assertFalse($mailExists);
    }
}
