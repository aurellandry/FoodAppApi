<?php

declare(strict_types=1);

namespace Tests\Domain\User\UseCase\Register;

use Domain\Shared\Error\ErrorResponse;
use Domain\Shared\ValueObject\Email;
use Domain\Shared\ValueObject\UserIdentifier;
use Domain\User\Entity\User;
use Domain\User\UseCase\Register\UserRegister;
use Domain\User\UseCase\Register\UserRegisterPresenterInterface;
use Domain\User\UseCase\Register\UserRegisterRequest;
use Domain\User\UseCase\Register\UserRegisterResponse;
use Domain\User\ValueObject\Role;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Tests\Support\Factory\FakeUserFactory;
use Tests\Support\Fake\FakeUserRegisterRequestValidator;
use Tests\Support\Repository\FakeUserRepository;

class UserRegisterTest extends TestCase implements UserRegisterPresenterInterface
{
    private ?UserRegisterResponse $response = null;
    private ?ErrorResponse $errors = null;

    public function testThatUserIsSaved(): void
    {
        // Given
        $sut = new UserRegister(
            new FakeUserFactory(),
            new FakeUserRepository(),
            (new FakeUserRegisterRequestValidator())->shouldBeValid()
        );
        $request = new UserRegisterRequest(
            'john.doe@test.com',
            'John',
            'Doe',
            'password'
        );

        // When
        $sut->execute($request, $this);

        // Then
        $expectedUserResponse = new UserRegisterResponse(
            new User(
                UserIdentifier::fromString('1558fa4d-2c64-42e8-9269-5ecb52dcba78'),
                Email::fromString('john.doe@test.com'),
                Role::User,
                'John',
                'Doe',
                base64_encode('password')
            )
        );
        $this->assertEquals($expectedUserResponse, $this->response);
    }

    public function testThatUserIsNotSavedWithInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $sut = new UserRegister(
            new FakeUserFactory(),
            new FakeUserRepository(),
            (new FakeUserRegisterRequestValidator())->shouldBeValid()
        );
        $request = new UserRegisterRequest(
            'fake-email',
            'John',
            'Doe',
            'password'
        );

        $sut->execute($request, $this);
    }

    public function testThatUserIsNotSavedIfValidationFailed(): void
    {
        // Given
        $sut = new UserRegister(
            new FakeUserFactory(),
            new FakeUserRepository(),
            (new FakeUserRegisterRequestValidator())->shouldBeInvalid()
        );
        $request = new UserRegisterRequest(
            'john.doe@test.com',
            'John',
            'Doe',
            'password'
        );

        // When
        $sut->execute($request, $this);

        // Then
        $this->assertNull($this->response);
        $this->assertNotNull($this->errors);
    }

    public function present(UserRegisterResponse $response): void
    {
        $this->response = $response;
    }

    public function presentError(ErrorResponse $errorResponse): void
    {
        $this->errors = $errorResponse;
    }

    public function displayViewModel(): mixed
    {
        return [];
    }
}
