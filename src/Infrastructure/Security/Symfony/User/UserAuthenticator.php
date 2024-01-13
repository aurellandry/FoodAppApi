<?php

declare(strict_types=1);

namespace Infrastructure\Security\Symfony\User;

use Domain\Shared\Error\ErrorResponse;
use Domain\User\UseCase\Login\UserLogin;
use Domain\User\UseCase\Login\UserLoginPresenterInterface;
use Domain\User\UseCase\Login\UserLoginRequest;
use Domain\User\UseCase\Login\UserLoginResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Serializer\SerializerInterface;

final class UserAuthenticator extends AbstractAuthenticator implements UserLoginPresenterInterface
{
    private UserLoginResponse|ErrorResponse $response;

    public function __construct(
        private readonly UserLogin $login,
        private readonly SerializerInterface $serializer,
        #[Autowire(service: AuthenticationSuccessHandler::class)]
        private readonly AuthenticationSuccessHandlerInterface $authenticationSuccessHandler
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return 'api_login' === $request->get('_route')
            && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $loginRequest = $this->serializer->deserialize(
            $request->getContent(),
            UserLoginRequest::class,
            'json'
        );

        $this->login->execute($loginRequest, $this);

        if (!$this->response instanceof UserLoginResponse) {
            throw new CustomUserMessageAuthenticationException();
        }

        return new SelfValidatingPassport(
            new UserBadge($this->response->email)
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return $this->authenticationSuccessHandler->onAuthenticationSuccess($request, $token);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        /** @var ErrorResponse $errorResponse */
        $errorResponse = $this->response;
        $data = [
            'errors' => \iterator_to_array($errorResponse->errorList),
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function presentError(ErrorResponse $errorResponse): void
    {
        $this->response = $errorResponse;
    }

    public function present(UserLoginResponse $response): void
    {
        $this->response = $response;
    }
}
