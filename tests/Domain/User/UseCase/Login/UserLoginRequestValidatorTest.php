<?php

declare(strict_types=1);

namespace Tests\Domain\User\UseCase\Register;

use Domain\User\UseCase\Login\UserLoginRequest;
use Domain\User\UseCase\Login\UserLoginRequestValidator;
use PHPUnit\Framework\TestCase;
use Tests\Support\Fake\FakeUserPasswordHasher;
use Tests\Support\Repository\FakeUserRepository;

class UserLoginRequestValidatorTest extends TestCase
{
    /**
     * @dataProvider userLoginRequestProvider
     */
    public function testValidate(
        UserLoginRequest $request,
        bool $isExpectedToBeValid
    ): void {
        // Given
        $sut = new UserLoginRequestValidator(
            new FakeUserRepository(),
            new FakeUserPasswordHasher()
        );

        // When
        $isValid = $sut->validate($request);

        // Then
        $this->assertEquals($isExpectedToBeValid, $isValid);
    }

    public function userLoginRequestProvider(): \Iterator
    {
        yield 'User Login request is valid' => [
            new UserLoginRequest(
                'dummy.user@test.com',
                'password'
            ),
            true
        ];

        yield 'User Login request doesn\'t have a valid password' => [
            new UserLoginRequest(
                'dummy.user@test.com',
                'invalidPassword'
            ),
            false
        ];

        yield 'User Login request doesn\'t have a valid email' => [
            new UserLoginRequest(
                'john.doe@test.com',
                'password'
            ),
            false
        ];
    }
}
