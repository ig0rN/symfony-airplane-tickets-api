<?php

namespace App\Controller;

use App\Feature\Ticket\Action\CancelAction;
use App\Feature\Ticket\Action\ChangeSeatAction;
use App\Feature\Ticket\Action\CreateAction;
use App\Feature\Ticket\DTO\ChangeSeatRequest;
use App\Feature\Ticket\DTO\CreateRequest;
use App\Service\RequestDTOFactory;
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
        name: 'create',
        methods: [Request::METHOD_POST]
    )]
    public function create(
        Request $request,
        RequestDTOFactory $requestDTOFactory,
        CreateAction $createAction,
    ): JsonResponse {
        $dto = $requestDTOFactory->make($request, CreateRequest::class);

        return new JsonResponse(
            $createAction->handleRequest($dto),
            Response::HTTP_CREATED
        );
    }

    #[Route(
        path: '/{uuid}/cancel',
        name: 'cancel',
        methods: [Request::METHOD_GET]
    )]
    public function cancel(
        string $uuid,
        CancelAction $cancelAction,
    ): JsonResponse {
        return new JsonResponse(
            $cancelAction->handleRequest($uuid),
            Response::HTTP_OK
        );
    }

    #[Route(
        path: '/{uuid}/change-seat',
        name: 'change-seat',
        methods: [Request::METHOD_PUT]
    )]
    public function changeSeat(
        Request $request,
        string $uuid,
        RequestDTOFactory $requestDTOFactory,
        ChangeSeatAction $changeSeatAction,
    ): JsonResponse {
        $dto = $requestDTOFactory->make($request, ChangeSeatRequest::class);

        return new JsonResponse(
            $changeSeatAction->handleRequest($uuid, $dto),
            Response::HTTP_OK
        );
    }
}
