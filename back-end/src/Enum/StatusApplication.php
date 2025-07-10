<?php

namespace App\Enum;

enum StatusApplication: string
{
    case ACTIVE = 'active';
    case UNDER_REVIEW = 'under_review';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
}
