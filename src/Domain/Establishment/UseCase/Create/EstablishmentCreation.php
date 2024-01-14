<?php

declare(strict_types=1);

namespace Domain\Establishment\UseCase\Create;

use Domain\Establishment\Factory\EstablishmentFactoryInterface;
use Domain\Establishment\Service\EstablishmentCreationRequestValidatorInterface;
use Domain\Establishment\Service\EstablishmentPersistenceCommand;
use Domain\Shared\Error\ErrorResponse;

final readonly class EstablishmentCreation
{
    public function __construct(
        private EstablishmentFactoryInterface $factory,
        private EstablishmentPersistenceCommand $persistence,
        private EstablishmentCreationRequestValidatorInterface $validator
    ) {
    }

    public function execute(
        EstablishmentCreationRequest $request,
        EstablishmentCreationPresenterInterface $presenter
    ): void {
        if (!$this->validator->validate($request)) {
            $presenter->presentError(
                new ErrorResponse(
                    $this->validator->getErrors()
                )
            );

            return;
        }

        $establishment = $this->factory->createFromRequest($request);

        $this->persistence->save($establishment);

        $presenter->present(new EstablishmentCreationResponse($establishment));
    }
}
