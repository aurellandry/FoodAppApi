<?php

declare(strict_types=1);

namespace Tests\Domain\User\Factory;

use Domain\User\Entity\User;
use Domain\User\Factory\UserFactory;
use Domain\User\UseCase\Register\UserRegisterRequest;
use PHPUnit\Framework\TestCase;
use Tests\Support\Fake\FakeUserPasswordHasher;
use Tests\Support\Generator\FakeIdentifierGenerator;

class UserFactoryTest extends TestCase
{
    public function testThatUserIsCreated(): void
    {
        // Given
        $sut = new UserFactory(
            new FakeIdentifierGenerator(),
            new FakeUserPasswordHasher
        );
        $givenRequest = new UserRegisterRequest(
            'user@test.com',
            'John',
            'Doe',
            'password'
        );

        // When
        $actualUser = $sut->createFromRequest($givenRequest);

        // Then
        self::assertInstanceOf(User::class, $actualUser);
    }
}
