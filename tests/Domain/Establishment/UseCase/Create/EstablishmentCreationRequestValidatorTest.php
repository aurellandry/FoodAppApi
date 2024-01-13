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
                'RESTAURANT',
                'Test Establishment',
                '+33601020304',
                '94 rue Beauvau',
                '75012',
                'Paris',
                'France',
                '55327987900672'
            ),
            true
        ];

        yield 'An invalid establishment creation request' => [
            new EstablishmentCreationRequest(
                'UNKNOWN',
                'Test Establishment',
                '+33601020304',
                '94 rue Beauvau',
                '75012',
                null,
                'France',
                '55327987900672'
            ),
            false
        ];
    }
}
