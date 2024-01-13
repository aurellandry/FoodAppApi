<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\ValueResolver\User;

use Domain\User\UseCase\Register\UserRegisterRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class UserRegisterRequestResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $type = $argument->getType();
        if (null === $type || !is_a($type, UserRegisterRequest::class, true)) {
            return [];
        }

        return [
            $this->serializer->deserialize(
                $request->getContent(),
                UserRegisterRequest::class,
                'json'
            ),
        ];
    }
}
