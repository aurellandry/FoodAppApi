<?php

declare(strict_types=1);

namespace Domain\Establishment\Factory;

use Domain\Establishment\UseCase\Create\EstablishmentCreationRequest;
use Domain\Establishment\Entity\Establishment;
use InvalidArgumentException;

final class EstablishmentFactory implements EstablishmentFactoryInterface
{
    /** @var ConcreteEstablishmentFactoryInterface[] */
    private array $concreteEstablishmentFactories = [];

    public function __construct(
        RestaurantFactory $restaurantFactory
    ) {
        $this->concreteEstablishmentFactories[] = $restaurantFactory;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function createFromRequest(EstablishmentCreationRequest $request): Establishment
    {
        foreach ($this->concreteEstablishmentFactories as $establishmentFactory) {
            if ($establishmentFactory->supports($request->type)) {
                return $establishmentFactory->createFromRequest($request);
            }
        }

        throw new InvalidArgumentException(
            sprintf('Unknown Establishment type "%s"', $request->type)
        );
    }
}
