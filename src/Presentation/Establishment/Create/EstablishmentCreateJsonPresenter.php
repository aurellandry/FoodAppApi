<?php

declare(strict_types=1);

namespace Presentation\Establishment\Create;

use Domain\Establishment\UseCase\Create\EstablishmentCreationPresenterInterface;
use Domain\Establishment\UseCase\Create\EstablishmentCreationResponse;
use Domain\Shared\Error\Error;
use Domain\Shared\Error\ErrorResponse;
use Presentation\Shared\Json\ErrorJsonViewModel;
use Presentation\Shared\Json\ErrorViewModel;

final readonly class EstablishmentCreateJsonPresenter implements EstablishmentCreationPresenterInterface
{
    private EstablishmentCreateJsonViewModel|ErrorJsonViewModel $response;

    public function present(EstablishmentCreationResponse $response): void
    {
        $this->response = new EstablishmentCreateJsonViewModel();
        $this->response->establishment = new EstablishmentCreateViewModel(
            (string) $response->establishment->getId()
        );
    }

    public function presentError(ErrorResponse $response): void
    {
        $this->response = new ErrorJsonViewModel();
        $this->response->httpCode = 400;
        $this->response->errors = array_map(
            fn (Error $error) => new ErrorViewModel(
                $error->fieldName,
                $error->message
            ),
            iterator_to_array($response->errorList)
        );
    }

    public function displayViewModel(): mixed
    {
        return $this->response;
    }
}
