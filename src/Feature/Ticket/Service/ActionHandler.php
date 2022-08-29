<?php

namespace App\Feature\Ticket\Service;

use App\Feature\Ticket\Action\CancelAction;
use App\Feature\Ticket\Action\ChangeSeatAction;
use App\Feature\Ticket\Action\CreateAction;
use App\Feature\Ticket\Enum\Action;
use App\Feature\Ticket\Interface\ActionInterface;
use App\Feature\Ticket\Interface\ActionRequestModel;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class ActionHandler implements ServiceSubscriberInterface
{
    public function __construct(
        private readonly ContainerInterface $locator,
        private readonly LoggerInterface $logger,
    ) {
    }

    public static function getSubscribedServices(): array
    {
        return [
            Action::CREATE->value => CreateAction::class,
            Action::CANCEL->value => CancelAction::class,
            Action::CHANGE_SEAT->value => ChangeSeatAction::class,
        ];
    }

    public function getResponseFromAction(ActionRequestModel $requestModel): array
    {
        $action = $this->getAction($requestModel->getAction());

        $responseData = $action->getResponseFromAction($requestModel);

        $this->logger->info('Ticket Response Data', [
            'Action' => $requestModel->getAction()->name,
            'Data' => $responseData,
        ]);

        return $responseData;
    }

    private function getAction(Action $action): ActionInterface
    {
        if (!$this->locator->has($action->value)) {
            throw new \RuntimeException(sprintf('Action not registered for value: [%s}', $action->value));
        }

        return $this->locator->get($action->value);
    }
}
