<?php

namespace App\Enum;

enum StatusJob: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case EXPIRED = 'expired';
}
