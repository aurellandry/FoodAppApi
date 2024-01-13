<?php

declare(strict_types=1);

namespace Presentation\User\Register;

use Presentation\Shared\Json\ErrorViewModel;
use Presentation\Shared\Json\JsonViewModelInterface;

final class UserRegisterJsonViewModel implements JsonViewModelInterface
{
    public int $httpCode = 200;

    public ?UserRegisterViewModel $user;

    /**
     * @var ErrorViewModel[]
     */
    public array $errors;

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }
}
