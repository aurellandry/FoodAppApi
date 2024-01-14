<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\EventSubscriber;

use Presentation\Shared\Json\JsonViewModelInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class JsonViewModelTransformerListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => 'transformToJsonResponse',
        ];
    }

    public function transformToJsonResponse(ViewEvent $event): void
    {
        $controllerResult = $event->getControllerResult();

        if (!$controllerResult instanceof JsonViewModelInterface) {
            return;
        }

        $jsonResponse = new JsonResponse(
            $controllerResult,
            $controllerResult->getHttpCode(),
        );

        $event->setResponse($jsonResponse);
    }
}
