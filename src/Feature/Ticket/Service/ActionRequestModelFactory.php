<?php

namespace App\Feature\Ticket\Service;

use App\Feature\Ticket\Enum\Action;
use App\Feature\Ticket\Exception\UnavailableActionException;
use App\Feature\Ticket\Interface\ActionRequestModel;
use App\Feature\Ticket\Model\CancelRequest;
use App\Feature\Ticket\Model\ChangeSeatRequest;
use App\Feature\Ticket\Model\CreateRequest;
use App\Service\RequestDTOFactory;
use Symfony\Component\HttpFoundation\Request;

class ActionRequestModelFactory
{
    private static function MAP(): array
    {
        return [
            Action::CREATE->value => CreateRequest::class,
            Action::CANCEL->value => CancelRequest::class,
            Action::CHANGE_SEAT->value => ChangeSeatRequest::class,
        ];
    }

    public function __construct(
        private readonly RequestDTOFactory $requestDTOFactory,
    ) {
    }

    public function make(Request $request, string $action): ActionRequestModel
    {
        try {
            $actionEnum = Action::from($action);
        } catch (\Throwable) {
            throw new UnavailableActionException(sprintf('Non existing HTTP action: [%s]', $action));
        }

        $class = self::MAP()[$actionEnum->value];

        /** @var ActionRequestModel $requestModel */
        $requestModel = $this->requestDTOFactory->make($request, $class);

        return $requestModel->setAction($actionEnum);
    }
}
