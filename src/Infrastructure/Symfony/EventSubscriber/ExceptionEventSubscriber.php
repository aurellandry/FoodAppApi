<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        // return the subscribed events, their methods and priorities
        return [
            KernelEvents::EXCEPTION => 'processException',
        ];
    }

    public function processException(ExceptionEvent $event): void
    {
        if ($event->getThrowable() instanceof AccessDeniedHttpException) {
            $jsonResponse = new JsonResponse(
                ['error' => 'Access denied'],
                Response::HTTP_FORBIDDEN,
            );

            $event->setResponse($jsonResponse);
        }
    }
}
