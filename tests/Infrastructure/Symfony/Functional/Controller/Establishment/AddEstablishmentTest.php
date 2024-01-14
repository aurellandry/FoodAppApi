<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Symfony\Functional\Controller\Establishment;

use Domain\Establishment\UseCase\Create\EstablishmentCreationRequest;
use Domain\User\UseCase\Login\UserLoginRequest;
use Tests\Infrastructure\Symfony\Functional\Controller\AbstractWebTestCase;

final class AddEstablishmentTest extends AbstractWebTestCase
{
    /**
     * @throws \JsonException
     */
    public function testEstablishmentCreationIsSuccessfulWhenUserIsAdmin(): void
    {
        // Given
        $client = self::createAuthenticatedClient(
            request: new UserLoginRequest(
                email: 'admin@mail.com',
                password: 'password'
            )
        );
        $givenRequest = new EstablishmentCreationRequest(
            type: 'RESTAURANT',
            name: 'Quick',
            siret: '55327987900672',
            phone: '+237681920932',
            address: 'Carrefour bastos',
            city: 'Yaoundé',
            country: 'Cameroun',
            zipcode: null
        );

        // When
        $client->request(
            method: 'POST',
            uri: '/api/establishments',
            server: [
                'CONTENT-TYPE' => 'application/json'
            ],
            content: json_encode($givenRequest, JSON_THROW_ON_ERROR)
        );

        // Then
        self::assertResponseIsSuccessful();

        $response = json_decode(
            $client->getResponse()->getContent(),
            true
        );
        self::assertEquals(201, $response['httpCode']);
        self::assertNotEmpty($response['establishment']);
        self::assertNotEmpty($response['establishment']['uuid']);
    }

    public function testEstablishmentCreationFailsWhenUserNotAdmin(): void
    {
        // Given
        $client = self::createAuthenticatedClient(
            request: new UserLoginRequest(
                email: 'dummy-user@mail.com',
                password: 'dummy-password'
            )
        );
        $givenRequest = new EstablishmentCreationRequest(
            type: 'RESTAURANT',
            name: 'Quick',
            siret: '55327987900672',
            phone: '+237681920932',
            address: 'Carrefour bastos',
            city: 'Yaoundé',
            country: 'Cameroun',
            zipcode: null
        );

        // When
        $client->request(
            method: 'POST',
            uri: '/api/establishments',
            server: [
                'CONTENT-TYPE' => 'application/json'
            ],
            content: json_encode($givenRequest, JSON_THROW_ON_ERROR)
        );

        // Then
        self::assertResponseStatusCodeSame(403);

        $response = json_decode($client->getResponse()->getContent(), true);
        self::assertNotEmpty($response['error']);
        self::assertEquals('Access denied', $response['error']);
    }

    public function testEstablishmentCreationFailsWhenUserNotConnected(): void
    {
        // Given
        $client = self::createClient();
        $givenRequest = new EstablishmentCreationRequest(
            type: 'RESTAURANT',
            name: 'Quick',
            siret: '55327987900672',
            phone: '+237681920932',
            address: 'Carrefour bastos',
            city: 'Yaoundé',
            country: 'Cameroun',
            zipcode: null
        );

        // When
        $client->request(
            method: 'POST',
            uri: '/api/establishments',
            server: [
                'CONTENT-TYPE' => 'application/json'
            ],
            content: json_encode($givenRequest, JSON_THROW_ON_ERROR)
        );

        // Then
        self::assertResponseStatusCodeSame(401);
    }

    public function testEstablishmentCreationFailsWhenBadRequest(): void
    {
        // Given
        $client = self::createAuthenticatedClient(
            request: new UserLoginRequest(
                email: 'admin@mail.com',
                password: 'password'
            )
        );
        $givenRequest = new EstablishmentCreationRequest(
            type: 'TOTO',
            name: 'Quick',
            siret: '55327987900672',
            phone: '+237681920932',
            address: 'Carrefour bastos',
            city: '',
            country: 'Cameroun',
            zipcode: null
        );

        // When
        $client->request(
            method: 'POST',
            uri: '/api/establishments',
            server: [
                'CONTENT-TYPE' => 'application/json'
            ],
            content: json_encode($givenRequest, JSON_THROW_ON_ERROR)
        );

        // Then
        self::assertResponseStatusCodeSame(400);

        $response = json_decode(
            $client->getResponse()->getContent(),
            true
        );
        self::assertNotEmpty($response['errors']);
    }
}
