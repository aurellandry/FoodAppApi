<?php

declare(strict_types=1);

namespace Presentation\User\Register;

use Domain\Shared\Error\Error;
use Domain\Shared\Error\ErrorResponse;
use Domain\User\UseCase\Register\UserRegisterResponse;
use Presentation\Shared\Json\ErrorJsonViewModel;
use Presentation\Shared\Json\ErrorViewModel;
use Domain\User\UseCase\Register\UserRegisterPresenterInterface;

final readonly class UserRegisterJsonPresenter implements UserRegisterPresenterInterface
{
    private UserRegisterJsonViewModel|ErrorJsonViewModel $viewModel;

    public function present(UserRegisterResponse $response): void
    {
        $this->viewModel = new UserRegisterJsonViewModel();
        $this->viewModel->user = new UserRegisterViewModel(
            (string) $response->user->getIdentifier()
        );
    }

    public function displayViewModel(): UserRegisterJsonViewModel|ErrorJsonViewModel
    {
        return $this->viewModel;
    }

    public function presentError(ErrorResponse $errorResponse): void
    {
        $this->viewModel = new ErrorJsonViewModel();
        $this->viewModel->httpCode = 400;
        $this->viewModel->errors = array_map(
            fn (Error $error) => new ErrorViewModel($error->fieldName, $error->message),
            \iterator_to_array($errorResponse->errorList)
        );
    }
}
