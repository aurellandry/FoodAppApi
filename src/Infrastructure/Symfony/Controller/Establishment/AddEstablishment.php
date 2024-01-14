<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Controller\Establishment;

use Domain\Establishment\UseCase\Create\EstablishmentCreation as EstablishmentCreationUseCase;
use Domain\Establishment\UseCase\Create\EstablishmentCreationPresenterInterface;
use Domain\Establishment\UseCase\Create\EstablishmentCreationRequest;
use Infrastructure\Symfony\ValueResolver\Establishment\EstablishmentCreationRequestResolver;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
#[Route(
    path: '/api/establishments',
    name: 'api_establishments_create',
    methods: ['POST']
)]
#[IsGranted('ROLE_ADMIN')]
final readonly class AddEstablishment
{
    public function __construct(
        private EstablishmentCreationUseCase $useCase,
        private EstablishmentCreationPresenterInterface $presenter
    ) {
    }

    public function __invoke(
        #[ValueResolver(EstablishmentCreationRequestResolver::class)]
        EstablishmentCreationRequest $request
    ): mixed {
        $this->useCase->execute($request, $this->presenter);

        return $this->presenter->displayViewModel();
    }
}
