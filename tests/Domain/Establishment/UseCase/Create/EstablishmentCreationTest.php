<?php

declare(strict_types=1);

namespace Tests\Domain\Establishment\UseCase\Create;

use Domain\Establishment\Entity\Restaurant;
use Domain\Establishment\UseCase\Create\EstablishmentCreation;
use Domain\Establishment\UseCase\Create\EstablishmentCreationPresenterInterface;
use Domain\Establishment\UseCase\Create\EstablishmentCreationRequest;
use Domain\Establishment\UseCase\Create\EstablishmentCreationResponse;
use Domain\Shared\Error\ErrorResponse;
use Domain\Shared\ValueObject\Address;
use Domain\Shared\ValueObject\EstablishmentIdentifier;
use Domain\Shared\ValueObject\Phone;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Tests\Support\Factory\FakeEstablishmentFactory;
use Tests\Support\Fake\FakeEstablishmentCreationRequestValidator;
use Tests\Support\Repository\FakeEstablishmentRepository;

class EstablishmentCreationTest extends TestCase implements EstablishmentCreationPresenterInterface
{
    private ?EstablishmentCreationResponse $response = null;
    private ?ErrorResponse $errors = null;

    public function testRestaurantCreationIsSuccessful(): void
    {
        // Given
        $sut = new EstablishmentCreation(
            new FakeEstablishmentFactory(),
            new FakeEstablishmentRepository(),
            (new FakeEstablishmentCreationRequestValidator())->shouldBeValid()
        );
        $request = new EstablishmentCreationRequest(
            'RESTAURANT',
            'My Test Establishment',
            '+33601020304',
            '94 rue Beauvau',
            '75012',
            'Paris',
            'France',
            '55327987900672'
        );

        // When
        $sut->execute($request, $this);

        // Then
        $this->assertInstanceOf(Restaurant::class, $this->response->establishment);
        $this->assertEquals(
            new Restaurant(
                EstablishmentIdentifier::fromString(
                    'c6da0062-0e8f-4e99-bcbc-22b1431535c9'
                ),
                'My Test Establishment',
                new Address('94 rue Beauvau', '75012', 'Paris', 'France'),
                Phone::fromString('+33601020304'),
                '55327987900672'
            ),
            $this->response->establishment
        );
    }

    public function testUnkownEstablishmentTypeCreationFails(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $sut = new EstablishmentCreation(
            new FakeEstablishmentFactory(),
            new FakeEstablishmentRepository(),
            (new FakeEstablishmentCreationRequestValidator())->shouldBeValid()
        );
        $request = new EstablishmentCreationRequest(
            'UNKNOWN',
            'My Test Establishment',
            '+33601020304',
            '94 rue Beauvau',
            '75012',
            'Paris',
            'France',
            '553 279 879 00672'
        );

        $sut->execute($request, $this);
    }

    public function testRestaurantCreationShouldFail(): void
    {
        // Given
        $sut = new EstablishmentCreation(
            new FakeEstablishmentFactory(),
            new FakeEstablishmentRepository(),
            (new FakeEstablishmentCreationRequestValidator())->shouldBeInvalid()
        );
        $request = new EstablishmentCreationRequest(
            'RESTAURANT',
            'My Test Establishment',
            '+33601020304',
            '94 rue Beauvau',
            '75012',
            'Paris',
            'France',
            '55327987900672'
        );

        // When
        $sut->execute($request, $this);

        // Then
        $this->assertNotNull($this->errors);
        $this->assertNull($this->response);
    }

    public function present(EstablishmentCreationResponse $response): void
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
