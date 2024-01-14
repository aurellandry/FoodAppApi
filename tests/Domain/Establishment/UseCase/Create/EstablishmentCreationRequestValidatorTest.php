<?php

declare(strict_types=1);

namespace Tests\Domain\Establishment\UseCase\Create;

use Domain\Establishment\UseCase\Create\EstablishmentCreationRequest;
use Domain\Establishment\UseCase\Create\EstablishmentCreationRequestValidator;
use PHPUnit\Framework\TestCase;
use Tests\Support\Repository\FakeEstablishmentRepository;

final class EstablishmentCreationRequestValidatorTest extends TestCase
{
    /**
     * @dataProvider establishmentCreationRequestProvider
     */
    public function testValidate(
        EstablishmentCreationRequest $request,
        bool $isExpectedToBeValid
    ): void {
        // Given
        $sut = new EstablishmentCreationRequestValidator(
            new FakeEstablishmentRepository()
        );

        // When
        $isValid = $sut->validate($request);

        // Then
        $this->assertEquals($isExpectedToBeValid, $isValid);
    }

    public function establishmentCreationRequestProvider(): \Iterator
    {
        yield 'A valid establishment creation request' => [
            new EstablishmentCreationRequest(
                type: 'RESTAURANT',
                name: 'Test Establishment',
                siret: '55327987900672',
                phone: '+33601020304',
                address: '94 rue Beauvau',
                zipcode: '75012',
                city: 'Paris',
                country: 'France',
            ),
            true
        ];

        yield 'An invalid establishment creation request - unknown type' => [
            new EstablishmentCreationRequest(
                type: 'UNKNOWN',
                name: 'Test Establishment',
                phone: '+33601020304',
                address: '94 rue Beauvau',
                zipcode: '75012',
                city: 'Paris',
                country: 'France',
                siret: '55327987900672'
            ),
            false
        ];

        yield 'An invalid establishment creation request - Incomplete address' => [
            new EstablishmentCreationRequest(
                type: 'RESTAURANT',
                name: 'Test Establishment',
                phone: '+33601020304',
                address: '94 rue Beauvau',
                zipcode: '75012',
                city: '',
                country: 'France',
                siret: '55327987900672'
            ),
            false
        ];
    }
}
