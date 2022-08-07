<?php

namespace App\Controller;

use App\Feature\Ticket\Action\CancelAction;
use App\Feature\Ticket\DTO\CreateRequest;
use App\Service\RequestDTOFactory;
use App\Feature\Ticket\Action\CreateAction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/tickets',
    name: 'tickets_'
)]
class TicketController extends AbstractController
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
            $createAction->getResponseData($dto),
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
            $cancelAction->getResponseData($uuid),
            Response::HTTP_OK
        );
    }
}
