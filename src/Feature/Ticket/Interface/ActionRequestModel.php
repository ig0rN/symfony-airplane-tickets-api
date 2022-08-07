<?php

namespace App\Feature\Ticket\Interface;

use App\Feature\Ticket\Enum\Action;

interface ActionRequestModel
{
    public function getAction(): Action;

    public function setAction(Action $action): static;
}
