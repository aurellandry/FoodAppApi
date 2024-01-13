<?php

declare(strict_types=1);

namespace Tests\Domain\User\UseCase\Register;

use Domain\User\UseCase\Register\UserRegisterRequest;
use Domain\User\UseCase\Register\UserRegisterRequestValidator;
use PHPUnit\Framework\TestCase;
use Tests\Support\Repository\FakeUserRepository;

class UserRegisterRequestValidatorTest extends TestCase
{
    /**
     * @dataProvider userRegisterRequestProvider
     */
    public function testValidate(
        UserRegisterRequest $request,
        bool $isExpectedToBeValid
    ): void
    {
        // Given
        $sut = new UserRegisterRequestValidator(
            new FakeUserRepository()
        );

        // When
        $isValid = $sut->validate($request);

        // Then
        $this->assertEquals($isExpectedToBeValid, $isValid);
    }

    public function userRegisterRequestProvider(): \Iterator
    {
        yield 'User register request is valid' => [
            new UserRegisterRequest(
                'john.doe@test.com',
                'John',
                'Doe',
                'password'
            ),
            true
        ];

        yield 'User register request doesn\'t have a first name' => [
            new UserRegisterRequest(
                'john.doe@test.com',
                '',
                'Doe',
                'password'
            ),
            true
        ];

        yield 'User register request doesn\'t have a last name' => [
            new UserRegisterRequest(
                'john.doe@test.com',
                'John',
                '',
                'password'
            ),
            false
        ];

        yield 'User register request doesn\'t have a password' => [
            new UserRegisterRequest(
                'john.doe@test.com',
                'John',
                'Doe',
                ''
            ),
            false
        ];

        yield 'User register request has already existing email' => [
            new UserRegisterRequest(
                'dummy.user@test.com',
                'Dummy',
                'User',
                'password'
            ),
            false
        ];
    }
}
