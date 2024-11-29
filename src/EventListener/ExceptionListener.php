<?php

declare(strict_types=1);


namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse();

        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;
        $response->setStatusCode($statusCode);

        $response->setData([
            'success' => false,
            'error' => [
                'message' => $exception->getMessage(),
                'code' => $statusCode,
            ]
        ]);

        $event->setResponse($response);
    }
}