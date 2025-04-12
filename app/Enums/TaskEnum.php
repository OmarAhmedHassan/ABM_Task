<?php

namespace App\Enums;

enum TaskEnum: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in-progress';
    case COMPLETED = 'completed';
}
