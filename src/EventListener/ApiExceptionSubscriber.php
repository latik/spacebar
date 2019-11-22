<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ApiProblemException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getException();
        if (!$e instanceof ApiProblemException) {
            return;
        }

        $response = new JsonResponse(
            $e->getViolations(),
            $e->getStatusCode()
        );
        $response->headers->set('Content-Type', 'application/problem+json');

        $event->setResponse($response);
    }
}
