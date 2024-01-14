<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Symfony\Functional\Controller;

use Domain\User\UseCase\Login\UserLoginRequest;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractWebTestCase extends WebTestCase
{
    /**
     * @throws \JsonException
     */
    protected static function createAuthenticatedClient(UserLoginRequest $request = null): KernelBrowser
    {
        $request = $request ?? new UserLoginRequest(
            email: 'dummy-user@mail.com',
            password: 'dummy-password'
        );

        $client = self::createClient();
        self::insertUserData();

        $client->request(
            method: 'POST',
            uri: '/api/login',
            server: [
                'CONTENT_TYPE' => 'application/json',
                'ACCEPT_TYPE' => 'application/json',
            ],
            content: json_encode($request, JSON_THROW_ON_ERROR)
        );

        /** @var array<string, string> $data */
        $data = json_decode(
            json: (string) $client->getResponse()->getContent(),
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );

        $client->setServerParameter(
            'HTTP_Authorization',
            sprintf('Bearer %s', $data['token'])
        );

        return $client;
    }

    protected static function insertUserData(): void
    {
        self::getContainer()->get('doctrine.dbal.default_connection')->executeStatement(
            'INSERT INTO users (id, first_name, last_name, email, role, password) VALUES (:id, :first_name, :last_name, :email, :role, :password)',
            [
                'id' => '86c04286-4154-4f8c-ab5d-3655da4889af',
                'first_name' => 'Dummy',
                'last_name' => 'User',
                'email' => 'dummy-user@mail.com',
                'role' => 'ROLE_USER',
                'password' => 'dummy-password',
            ]
        );

        self::getContainer()->get('doctrine.dbal.default_connection')->executeStatement(
            'INSERT INTO users (id, first_name, last_name, email, role, password) VALUES (:id, :first_name, :last_name, :email, :role, :password)',
            [
                'id' => '3f4c350e-2376-6331-a559-1de1a5ebd47b',
                'first_name' => 'Aurel',
                'last_name' => 'Landry',
                'email' => 'admin@mail.com',
                'role' => 'ROLE_ADMIN',
                'password' => 'password',
            ]
        );
    }
}
