<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Controller\User;

use Domain\User\UseCase\Register\UserRegister as UserRegisterUseCase;
use Domain\User\UseCase\Register\UserRegisterPresenterInterface;
use Domain\User\UseCase\Register\UserRegisterRequest;
use Infrastructure\Symfony\ValueResolver\User\UserRegisterRequestResolver;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route(path: '/api/users', name: 'api_users_register', methods: ['POST'])]
final readonly class UserRegister
{
    public function __construct(
        private UserRegisterUseCase $register,
        private UserRegisterPresenterInterface $presenter
    ) {
    }

    public function __invoke(
        #[ValueResolver(UserRegisterRequestResolver::class)]
        UserRegisterRequest $request
    ): mixed {
        $this->register->execute($request, $this->presenter);

        return $this->presenter->displayViewModel();
    }
}
