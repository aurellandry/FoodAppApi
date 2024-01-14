<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Symfony\Functional\Controller\User;

use Domain\User\UseCase\Register\UserRegisterRequest;
use Domain\User\ValueObject\Role;
use Tests\Infrastructure\Symfony\Functional\Controller\AbstractWebTestCase;

final class UserRegisterTest extends AbstractWebTestCase
{
    /**
     * @throws \JsonException
     */
    public function testRegisterUserSuccessfully(): void
    {
        // Given
        $client = self::createClient();
        $givenRequest = new UserRegisterRequest(
            email: 'new.user@mail.com',
            firstName: 'New',
            lastName: 'User',
            password: 'encoded-password',
            role: Role::RestaurantAdmin->value
        );

        // When
        $client->request(
            method: 'POST',
            uri: '/api/users',
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
            ],
            content: json_encode($givenRequest, JSON_THROW_ON_ERROR)
        );

        // Then
        self::assertResponseIsSuccessful();
    }

    public function testRegisterUserFails(): void
    {
        // Given
        $client = self::createClient();
        $givenRequest = new UserRegisterRequest(
            email: 'invalid-email',
            firstName: 'New',
            lastName: 'User',
            password: 'encoded-password',
            role: Role::RestaurantStaff->value
        );

        // When
        $client->request(
            method: 'POST',
            uri: '/api/users',
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
            ],
            content: json_encode($givenRequest, JSON_THROW_ON_ERROR)
        );

        // Then
        self::assertResponseStatusCodeSame(400);
    }
}
