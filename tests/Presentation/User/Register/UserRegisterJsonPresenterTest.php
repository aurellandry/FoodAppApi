<?php

declare(strict_types=1);

namespace Tests\Presentation\User\Register;

use Domain\Shared\Error\ErrorList;
use Domain\Shared\Error\ErrorResponse;
use Domain\Shared\ValueObject\Email;
use Domain\Shared\ValueObject\UserIdentifier;
use Domain\User\ValueObject\Role;
use Domain\User\Entity\User;
use Domain\User\UseCase\Register\UserRegisterResponse;
use Presentation\Shared\Json\ErrorJsonViewModel;
use Presentation\Shared\Json\ErrorViewModel;
use Presentation\User\Register\UserRegisterJsonPresenter;
use Presentation\User\Register\UserRegisterJsonViewModel;
use Presentation\User\Register\UserRegisterViewModel;
use PHPUnit\Framework\TestCase;

class UserRegisterJsonPresenterTest extends TestCase
{
    public function testThatReturnsViewModelWithUser(): void
    {
        // Given
        $sut = new UserRegisterJsonPresenter();

        $givenResponse = new UserRegisterResponse(
            new User(
                uuid: UserIdentifier::fromString(
                    '375e182c-f674-4aba-ba71-16f599114f94'
                ),
                firstName: 'Henry',
                lastName: 'Dupont',
                email: Email::fromString('h.d@mail.com'),
                role: Role::User,
            )
        );

        // When
        $sut->present($givenResponse);

        // Then
        $expectedViewModel = new UserRegisterJsonViewModel();
        $expectedViewModel->user = new UserRegisterViewModel(
            '375e182c-f674-4aba-ba71-16f599114f94'
        );

        self::assertEquals($expectedViewModel, $sut->displayViewModel());
    }

    public function testThatReturnsViewModelWithErrors(): void
    {
        // Given
        $sut = new UserRegisterJsonPresenter();

        $givenError = new ErrorList();
        $givenError->addError('error message', 'field name');
        $givenResponse = new ErrorResponse($givenError);

        // When
        $sut->presentError($givenResponse);

        // Then
        $expectedViewModel = new ErrorJsonViewModel();
        $expectedViewModel->httpCode = 400;
        $expectedViewModel->errors = [new ErrorViewModel('field name', 'error message')];

        self::assertEquals($expectedViewModel, $sut->displayViewModel());
    }
}
