<?php

namespace App\EventSubscriber;

use App\Exception\UnauthorizedException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 3000],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $authorizationToken = $event->getRequest()->headers->get('Authorization');

        if (empty($authorizationToken)) {
            throw new UnauthorizedException();
        }

        $token = str_replace('Bearer ', '', $authorizationToken);

        $tokens = $this->parameterBag->get('customers');

        if (!in_array($token, array_values($tokens))) {
            throw new UnauthorizedException();
        }
    }
}
