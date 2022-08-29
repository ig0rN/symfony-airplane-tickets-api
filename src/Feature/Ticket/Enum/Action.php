<?php

namespace App\Feature\Ticket\Enum;

enum Action: string
{
    case CREATE = 'create';
    case CANCEL = 'cancel';
    case CHANGE_SEAT = 'change-seat';
}
