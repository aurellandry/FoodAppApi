<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Symfony\Functional\Controller\User;

use Domain\User\UseCase\Login\UserLoginRequest;
use Tests\Infrastructure\Symfony\Functional\Controller\AbstractWebTestCase;

final class UserLoginTest extends AbstractWebTestCase
{
    /**
     * @throws \JsonException
     */
    public function testLoginSuccessfully(): void
    {
        // Given
        $client = self::createClient();
        self::insertUserData();

        $givenRequest = new UserLoginRequest(
            email: 'dummy-user@mail.com',
            password: 'dummy-password'
        );

        // When
        $client->request(
            method: 'POST',
            uri: '/api/login',
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
            ],
            content: \json_encode($givenRequest, JSON_THROW_ON_ERROR)
        );

        // Then
        self::assertResponseIsSuccessful();

        /** @var array<string, string> $actualContentData */
        $actualContentData = \json_decode(
            json: (string) $client->getResponse()->getContent(),
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );

        self::assertArrayHasKey('token', $actualContentData);
        self::assertNotEmpty($actualContentData['token']);
    }

    /**
     * @dataProvider provideWrongConnectionData
     *
     * @throws \JsonException
     */
    public function testLoginFailed(string $givenEmail, string $givenPassword): void
    {
        $client = self::createClient();
        $givenRequest = new UserLoginRequest(
            email: $givenEmail,
            password: $givenPassword,
        );

        $client->request(
            method: 'POST',
            uri: '/api/login',
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
            ],
            content: \json_encode($givenRequest, JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(401);
    }

    public function provideWrongConnectionData(): \Generator
    {
        yield 'With wrong email' => ['invalid-email', 'dummy-password'];
        yield 'With wrong password' => ['dummy-user@mail.com', 'invalid-password'];
        yield 'With missing email' => ['', 'dummy-password'];
        yield 'With missing password' => ['dummy-user@mail.com', ''];
    }
}
