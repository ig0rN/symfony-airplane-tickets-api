<?php

namespace App\Controller;

use App\Feature\Ticket\Service\ActionHandler;
use App\Feature\Ticket\Service\ActionRequestModelFactory;
use App\Feature\Ticket\Service\RequestValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/tickets',
    name: 'tickets_'
)]
class TicketController
{
    #[Route(
        path: '/{action}',
        methods: [Request::METHOD_POST]
    )]
    public function handle(
        Request $request,
        string $action,
        RequestValidator $requestValidator,
        ActionRequestModelFactory $requestModelFactory,
        ActionHandler $actionHandler,
    ): JsonResponse {
        $requestValidator->validateRequest($request, $action);

        $dto = $requestModelFactory->make($request, $action);

        return new JsonResponse(
            $actionHandler->getResponseFromAction($dto),
            Response::HTTP_OK
        );
    }
}
