<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ApiProblemException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
          KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
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
