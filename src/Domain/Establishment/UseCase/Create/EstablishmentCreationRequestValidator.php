<?php

declare(strict_types=1);

namespace Domain\Establishment\UseCase\Create;

use Domain\Establishment\Service\EstablishmentCreationRequestValidatorInterface;
use Domain\Establishment\Service\EstablishmentPersistenceQuery;
use Domain\Establishment\ValueObject\EstablishmentType;
use Domain\Shared\Error\ErrorList;
use Extension\Assert\Assert;
use Extension\Assert\LazyAssertionException;

final readonly class EstablishmentCreationRequestValidator implements EstablishmentCreationRequestValidatorInterface
{
    private ErrorList $errors;

    public function __construct(
        private EstablishmentPersistenceQuery $repository
    ) {
        $this->errors = new ErrorList();
    }

    public function validate(EstablishmentCreationRequest $request): bool
    {
        try {
            $isAddressComplete = self::isAddressComplete($request);
            $isTypeSupported = self::isEstablishmentTypeSupported($request->type);

            Assert::lazy()
                ->that($request->name, 'name')->notEmpty('Establishment name is required')
                ->that($request->siret, 'siret')->notEmpty('SIRET number is required')
                ->that($isAddressComplete, 'address')->true('Address must be complete')
                ->that($isTypeSupported, 'type')->true('Unknown establishment type')
                ->verifyNow();

            $establishmentExists = (bool) $this->repository->findBySiret($request->siret);
            Assert::lazy()
                ->that($establishmentExists, 'siret')->false('Establishment SIRET already exists')
                ->verifyNow();
        } catch (LazyAssertionException $exception) {
            foreach ($exception->getErrorExceptions() as $error) {
                $this->errors->addError(
                    $error->getMessage(),
                    $error->getPropertyPath()
                );
            }

            return false;
        }

        return true;
    }

    public function getErrors(): ErrorList
    {
        return $this->errors;
    }

    private static function isAddressComplete(EstablishmentCreationRequest $request): bool
    {
        return !empty($request->address)
            && !empty($request->city)
            && !empty($request->country);
    }

    private static function isEstablishmentTypeSupported(string $establishmentType): bool
    {
        try {
            EstablishmentType::from($establishmentType);

            return true;
        } catch (\Throwable) {
            return false;
        }
    }
}
