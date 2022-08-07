<?php

namespace App\EventSubscriber;

use App\Exception\AppException;
use App\Exception\ValidationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly LoggerInterface $apiTicketsLogger,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // the priority must be greater than the Security HTTP
            // ExceptionListener, to make sure it's called before
            // the default exception listener
            KernelEvents::EXCEPTION => ['onKernelException', 2],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        if ($e instanceof ValidationException) {
            $exceptionMessage = 'Validation Exception';

            $responseData = [
                'errors' => $e->getData(),
                'message' => $e->getMessage(),
            ];

            $responseCode = $e->getCode();
        } elseif ($e instanceof AppException) {
            $exceptionMessage = 'App Exception';

            $responseData = [
                'message' => $e->getMessage(),
            ];

            $responseCode = $e->getCode();
        } else {
            $exceptionMessage = 'Unknown Exception';

            $responseData = [
                'message' => $e->getMessage(),
            ];

            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $this->apiTicketsLogger->error($exceptionMessage, [
            'Message' => $e->getMessage(),
            'Code' => $e->getCode(),
            'Trance' => $e->getTrace(),
        ]);

        $event->setResponse(new JsonResponse($responseData, $responseCode));
    }
}
