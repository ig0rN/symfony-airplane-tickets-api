<?php

namespace App\Feature\Ticket\Service;

use App\Exception\InvalidRequestException;
use App\Exception\UnauthorizedException;
use App\Feature\Ticket\Enum\Action;
use App\Feature\Ticket\Exception\UnavailableActionException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestValidator
{
    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
    ) {
    }

    /**
     * @throws UnavailableActionException
     * @throws UnauthorizedException
     * @throws InvalidRequestException
     */
    public function validateRequest(Request $request, string $action): void
    {
        if (!$this->isAuthorized($request->headers->get('Authorization'))) {
            throw new UnauthorizedException();
        }

        if (null === $this->isActionAllowed($action)) {
            throw new UnavailableActionException(sprintf('Non existing HTTP action: [%s]', $action));
        }

        try {
            $request->toArray();
        } catch (\Throwable) {
            throw new InvalidRequestException('Request body is empty!');
        }
    }

    private function isAuthorized(?string $authorizationToken): bool
    {
        if (empty($authorizationToken)) {
            return false;
        }

        $token = str_replace('Bearer ', '', $authorizationToken);

        return $this->parameterBag->get('customers')['customer1Key'] === $token;
    }

    private function isActionAllowed(string $action): ?Action
    {
        return Action::tryFrom($action);
    }
}
