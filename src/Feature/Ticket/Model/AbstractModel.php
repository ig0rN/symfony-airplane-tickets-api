<?php

namespace App\Feature\Ticket\Model;

use App\Feature\Ticket\Enum\Action;
use App\Feature\Ticket\Interface\ActionRequestModel;

abstract class AbstractModel implements ActionRequestModel
{
    private Action $action;

    final public function setAction(Action $action): static
    {
        $this->action = $action;

        return $this;
    }

    final public function getAction(): Action
    {
        return $this->action;
    }
}
