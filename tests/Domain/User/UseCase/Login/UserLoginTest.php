<?php

declare(strict_types=1);

namespace Tests\Domain\User\UseCase\Login;

use Domain\Shared\Error\ErrorResponse;
use Domain\User\UseCase\Login\UserLogin;
use Domain\User\UseCase\Login\UserLoginPresenterInterface;
use Domain\User\UseCase\Login\UserLoginRequest;
use Domain\User\UseCase\Login\UserLoginResponse;
use PHPUnit\Framework\TestCase;
use Tests\Support\Fake\FakeUserLoginRequestValidator;
use Tests\Support\Repository\FakeUserRepository;

class UserLoginTest extends TestCase implements UserLoginPresenterInterface
{
    private ?UserLoginResponse $response = null;
    private ?ErrorResponse $errors = null;

    public function testThatUserLoginSucceeded(): void
    {
        // Given
        $sut = new UserLogin(
            new FakeUserRepository(),
            (new FakeUserLoginRequestValidator())->shouldBeValid()
        );
        $request = new UserLoginRequest(
            'dummy.user@test.com',
            'password'
        );

        // When
        $sut->execute($request, $this);

        // Then
        $expectedUserResponse = new UserLoginResponse('dummy.user@test.com');
        $this->assertEquals($expectedUserResponse, $this->response);
    }

    public function testUserLoginFailedReturnsErrorResponse(): void
    {
        // Given
        $sut = new UserLogin(
            new FakeUserRepository(),
            (new FakeUserLoginRequestValidator())->shouldBeInvalid()
        );
        $request = new UserLoginRequest(
            'dummy.user@test.com',
            'wrongPassword'
        );

        // When
        $sut->execute($request, $this);

        // Then
        $this->assertNotNull($this->errors);
        $this->assertNull($this->response);
    }

    public function present(UserLoginResponse $response): void
    {
        $this->response = $response;
    }

    public function presentError(ErrorResponse $errorResponse): void
    {
        $this->errors = $errorResponse;
    }
}
