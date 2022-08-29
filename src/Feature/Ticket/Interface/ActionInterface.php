<?php

namespace App\Feature\Ticket\Interface;

interface ActionInterface
{
    public function getResponseFromAction(ActionRequestModel $requestModel): array;
}
