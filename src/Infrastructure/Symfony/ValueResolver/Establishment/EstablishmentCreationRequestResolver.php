<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\ValueResolver\Establishment;

use Domain\Establishment\UseCase\Create\EstablishmentCreationRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class EstablishmentCreationRequestResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $type = $argument->getType();
        if (null === $type || !is_a($type, EstablishmentCreationRequest::class, true)) {
            return [];
        }

        return [
            $this->serializer->deserialize(
                $request->getContent(),
                EstablishmentCreationRequest::class,
                'json'
            ),
        ];
    }
}
